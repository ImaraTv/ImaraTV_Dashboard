<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('geo_countries', function (Blueprint $table) {
            $table->id();
            $table->string('iso2', 2);
            $table->string('name', 128);
            $table->integer('is_active');
            $table->string('call_code', 12)->nullable();
            $table->string('currency', 3)->nullable();
            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => 'CountriesSeeder',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('geo_countries');
    }
};
