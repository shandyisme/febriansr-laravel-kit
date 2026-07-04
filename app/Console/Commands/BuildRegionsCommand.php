<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BuildRegionsCommand extends Command
{
    protected $signature = 'region:build';

    protected $description = 'Build the denormalised regions table from the imported RajaOngkir tables';

    public function handle(): int
    {
        foreach (['rajaongkir_provinces', 'rajaongkir_cities', 'rajaongkir_districts', 'rajaongkir_subdistricts'] as $table) {
            if (! Schema::hasTable($table)) {
                $this->error("Missing source table [$table]. Import the RajaOngkir dump first.");

                return self::FAILURE;
            }
        }

        $this->info('Building regions from RajaOngkir tables…');
        DB::table('regions')->truncate();

        DB::statement("
            INSERT INTO regions (province, city, district, subdistrict, zip_code, label, search_text, created_at, updated_at)
            SELECT
                p.name, c.name, d.name, s.name, s.zip_code,
                CONCAT(s.name, ', ', d.name, ', ', c.name, ', ', p.name),
                LOWER(CONCAT(s.name, ' ', d.name, ' ', c.name, ' ', p.name, ' ', COALESCE(s.zip_code, ''))),
                NOW(), NOW()
            FROM rajaongkir_subdistricts s
            JOIN rajaongkir_districts d ON d.rajaongkir_id = s.district_id
            JOIN rajaongkir_cities c ON c.rajaongkir_id = d.city_id
            JOIN rajaongkir_provinces p ON p.rajaongkir_id = c.province_id
        ");

        $count = DB::table('regions')->count();
        $this->info("Done. {$count} regions built.");

        return self::SUCCESS;
    }
}
