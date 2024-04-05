<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('creator_profiles', function (Blueprint $table) {
            $table->id();

            $table->string('profile_picture')->nullable();
            $table->string('profile_banner')->nullable();
            $table->string('name');
            $table->string('stage_name')->nullable();
            $table->string('email')->unique();
            $table->string('mobile_phone')->nullable();
            $table->text('description')->nullable();
            $table->string('skills_and_talents')->nullable();
            $table->string('identification_number')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('payment_via')->nullable();
            $table->string('payment_account_number')->nullable();
            $table->string('kra_pin')->nullable();
            $table->string('location')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creator_profiles');
    }
};
