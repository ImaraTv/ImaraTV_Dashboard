<?php

use Illuminate\{
    Database\Migrations\Migration,
    Database\Schema\Blueprint,
    Support\Facades\Schema
};

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('publishing_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposal_id');
            $table->timestamp('release_date')->nullable();
            $table->string('film_title')->nullable();
            $table->string('topics')->nullable();
            $table->text('synopsis')->nullable();
            $table->string('film_type')->nullable();
            $table->decimal('premium_film_price')->nullable();
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->unsignedBigInteger('sponsor_id')->nullable();
            $table->string('call_to_action_text')->nullable();
            $table->string('call_to_action_link')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publishing_schedules');
    }
};
