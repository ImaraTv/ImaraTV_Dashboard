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
        Schema::create('sponsor_profiles', function (Blueprint $table) {
            $table->id();
            $table->text('about_us')->nullable();
            $table->string('organization_name')->nullable();
            $table->string('organization_website')->nullable();
            $table->text('topics_of_interest')->nullable();
            $table->text('locations_of_interest')->nullable();
            $table->string('contact_person_name')->nullable();
            $table->string('contact_person_email')->nullable();
            $table->string('contact_person_phone')->nullable();
            $table->string('contact_person_alt_phone')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes(); // Adds soft deletes functionality
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sponsor_profiles');
    }
};
