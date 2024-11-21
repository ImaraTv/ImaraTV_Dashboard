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
        Schema::table('creator_proposals', function (Blueprint $table) {
            $table->integer('is_published')->after('film_rating')->nullable();
            $table->timestamp('published_at')->after('is_published')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('creator_proposals', function (Blueprint $table) {
            $table->dropColumn(['is_published', 'published_at']);
        });
    }
};
