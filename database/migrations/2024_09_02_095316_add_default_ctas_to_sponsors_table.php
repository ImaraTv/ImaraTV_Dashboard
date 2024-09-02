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
        Schema::table('sponsor_profiles', function (Blueprint $table) {
            $table->string('default_cta_text', 255)->after('organization_website')->nullable();
            $table->string('default_cta_link', 255)->after('default_cta_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sponsor_profiles', function (Blueprint $table) {
            $table->dropColumn(['default_cta_text', 'default_cta_link']);
        });
    }
};
