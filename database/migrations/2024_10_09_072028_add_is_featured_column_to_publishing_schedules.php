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
        Schema::table('publishing_schedules', function (Blueprint $table) {
            $table->integer('is_featured')->after('call_to_action_link')->nullable();
            $table->timestamp('featured_at')->after('is_featured')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('publishing_schedules', function (Blueprint $table) {
            $table->dropColumn(['is_featured', 'featured_at']);
        });
    }
};
