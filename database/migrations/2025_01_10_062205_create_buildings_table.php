<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $sql = 'CREATE TABLE buildings (
                    id SERIAL PRIMARY KEY,
                    address VARCHAR(255) NOT NULL,
                    latitude FLOAT NOT NULL,
                    longitude FLOAT NOT NULL,
                    geom GEOGRAPHY(POINT),
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );';

        DB::statement($sql);
        DB::statement('CREATE INDEX idx_locations_geom ON buildings USING GIST(geom);');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buildings');

        DB::raw('DROP INDEX if exists idx_locations_geom;');
    }
};
