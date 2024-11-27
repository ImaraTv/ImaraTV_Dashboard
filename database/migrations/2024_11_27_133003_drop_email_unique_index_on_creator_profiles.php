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

        Schema::table('creator_profiles', function (Blueprint $table) {
            $indexesFound = collect(DB::select("SHOW INDEXES FROM creator_profiles"))
                ->mapToGroups(fn($row) => [$row->Key_name => $row->Column_name])
                ->toArray();
            if (array_key_exists('creator_profiles_email_unique', $indexesFound)) {
                $table->dropUnique('creator_profiles_email_unique');
            }
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('creator_profiles', function (Blueprint $table) {
            $table->unique('email', 'creator_profiles_email_unique');
        });
    }
};
