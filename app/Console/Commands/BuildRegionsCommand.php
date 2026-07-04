<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BuildRegionsCommand extends Command
{
    protected $signature = 'region:build';

    protected $description = 'Build the denormalised regions table (proper-cased) from the imported RajaOngkir tables';

    /** Acronyms to keep uppercase after title-casing. */
    private const ACRONYMS = ['Dki' => 'DKI', 'Di ' => 'DI ', 'Kh ' => 'KH '];

    public function handle(): int
    {
        foreach (['rajaongkir_provinces', 'rajaongkir_cities', 'rajaongkir_districts', 'rajaongkir_subdistricts'] as $table) {
            if (! Schema::hasTable($table)) {
                $this->error("Missing source table [{$table}]. Import the RajaOngkir dump first (region:import).");

                return self::FAILURE;
            }
        }

        $this->info('Building regions (proper case)…');
        DB::table('regions')->truncate();

        $now = now();
        $total = 0;

        DB::table('rajaongkir_subdistricts as s')
            ->join('rajaongkir_districts as d', 'd.rajaongkir_id', '=', 's.district_id')
            ->join('rajaongkir_cities as c', 'c.rajaongkir_id', '=', 'd.city_id')
            ->join('rajaongkir_provinces as p', 'p.rajaongkir_id', '=', 'c.province_id')
            ->select('s.id', 's.name as subdistrict', 'd.name as district', 'c.name as city', 'p.name as province', 's.zip_code as zip')
            ->orderBy('s.id')
            ->chunk(2000, function ($rows) use ($now, &$total) {
                $insert = [];
                foreach ($rows as $r) {
                    $sub = $this->proper($r->subdistrict);
                    $dist = $this->proper($r->district);
                    $city = $this->proper($r->city);
                    $prov = $this->proper($r->province);

                    $insert[] = [
                        'province' => $prov,
                        'city' => $city,
                        'district' => $dist,
                        'subdistrict' => $sub,
                        'zip_code' => $r->zip,
                        'label' => "{$sub}, {$dist}, {$city}, {$prov}",
                        'search_text' => mb_strtolower(trim("{$sub} {$dist} {$city} {$prov} ".($r->zip ?? ''))),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
                DB::table('regions')->insert($insert);
                $total += count($insert);
            });

        $this->info("Done. {$total} regions built.");

        return self::SUCCESS;
    }

    /** Title-case an ALL-CAPS Indonesian name, keeping known acronyms uppercase. */
    private function proper(string $name): string
    {
        $title = mb_convert_case(mb_strtolower(trim($name)), MB_CASE_TITLE, 'UTF-8');

        return strtr($title, self::ACRONYMS);
    }
}
