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
        Schema::table('events', function (Blueprint $table) {
            $table->integer('sponsored_by')->after('status')->nullable();
            $table->string('cta_text', 255)->after('sponsor_id')->nullable();
            $table->string('cta_link', 255)->after('cta_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['sponsor_id', 'cta_text', 'cta_link']);
        });
    }
};
