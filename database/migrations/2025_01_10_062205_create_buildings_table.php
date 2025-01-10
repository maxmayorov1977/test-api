<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->string('address')->nullable(false)->index()->comment('Адрес');
            $table->string('latitude')->nullable(false)->comment('Широта');
            $table->string('longitude')->nullable(false)->comment('Долгота');
            $table->timestamps();
        });

        DB::raw('ALTER TABLE buildings ADD geom GEOMETRY NOT NULL SRID 4326;');
        DB::raw('CREATE SPATIAL INDEX g ON geometry (geom);');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};
