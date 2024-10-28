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
        Schema::create('geo_counties', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->nullable();
            $table->string('name', 128);
            $table->string('country', 3);
            $table->integer('is_active');
            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => 'CountiesSeeder',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('geo_counties');
    }
};
