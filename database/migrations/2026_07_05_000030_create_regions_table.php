<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Denormalised Indonesian region table (one row per kelurahan/subdistrict with
 * the full path), populated from the imported RajaOngkir tables via
 * `php artisan region:build`. Powers the single-field address autocomplete.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('regions')) {
            return;
        }

        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('province');
            $table->string('city');
            $table->string('district');
            $table->string('subdistrict');
            $table->string('zip_code', 10)->nullable();
            $table->string('label');        // "Kelurahan, Kecamatan, Kota, Provinsi"
            $table->string('search_text');   // lowercased combined text for matching
            $table->timestamps();

            $table->index('zip_code');
            $table->index('search_text');
        });

        // Full-text search accelerates multi-word autocomplete (MySQL/MariaDB only).
        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE regions ADD FULLTEXT regions_search_ft (search_text)');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('regions');
    }
};
