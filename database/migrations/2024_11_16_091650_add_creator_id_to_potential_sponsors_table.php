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
        Schema::table('potential_sponsors', function (Blueprint $table) {
            $table->integer('creator_id')->after('sponsor_id')->nullable();
            $table->text('description')->after('proposal_id')->nullable();
            $table->bigInteger('proposal_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('potential_sponsors', function (Blueprint $table) {
            $table->dropColumn(['creator_id', 'description']);
        });
    }
};
