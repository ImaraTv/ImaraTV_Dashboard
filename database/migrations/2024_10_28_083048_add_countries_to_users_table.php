<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('country_id')->after('newsletter_consent')->nullable();
            $table->integer('state_id')->after('country_id')->nullable();
            $table->integer('county_id')->after('state_id')->nullable();
            $table->string('town', '128')->after('county_id')->nullable();
            $table->string('location', '128')->after('town')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['country_id', 'state_id', 'county_id', 'town', 'location']);
        });
    }
};
