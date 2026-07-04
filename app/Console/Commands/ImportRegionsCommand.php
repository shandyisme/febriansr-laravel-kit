<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportRegionsCommand extends Command
{
    protected $signature = 'region:import {file? : Path to a .sql or .sql.gz RajaOngkir dump}';

    protected $description = 'Import the RajaOngkir region dump (MySQL) then rebuild the regions table';

    public function handle(): int
    {
        $file = $this->argument('file') ?? database_path('data/rajaongkir-region.sql.gz');

        if (! is_file($file)) {
            $this->error("Dump not found: {$file}");

            return self::FAILURE;
        }

        if (config('database.default') !== 'mysql') {
            $this->error('region:import supports MySQL/MariaDB only. Set DB_CONNECTION=mysql.');

            return self::FAILURE;
        }

        $c = config('database.connections.mysql');
        $reader = str_ends_with($file, '.gz') ? 'gunzip -c' : 'cat';

        // Password via MYSQL_PWD env to keep it off the process list.
        putenv('MYSQL_PWD='.$c['password']);
        $cmd = sprintf(
            '%s %s | mysql -h%s -P%s -u%s %s',
            $reader,
            escapeshellarg($file),
            escapeshellarg((string) $c['host']),
            escapeshellarg((string) $c['port']),
            escapeshellarg((string) $c['username']),
            escapeshellarg((string) $c['database']),
        );

        $this->info('Importing region dump…');
        exec($cmd.' 2>&1', $out, $code);
        putenv('MYSQL_PWD');

        if ($code !== 0) {
            $this->error('Import failed: '.implode("\n", $out));

            return self::FAILURE;
        }

        $this->info('Imported. Building regions…');
        $this->call('region:build');

        return self::SUCCESS;
    }
}
