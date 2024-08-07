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
            $table->string('slug', 255)->after('film_title')->nullable();
            $table->index('slug');
        });

        // update existing film schedules to generate the slugs 
        foreach (\App\Models\PublishingSchedule::all() as $schedule) {
            $schedule->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('publishing_schedules', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->dropIndex(['slug']);
        });
    }
};
