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
        Schema::create('creator_proposals', function (Blueprint $table) {
            $table->id();
            $table->string('working_title');
            $table->string('topics')->nullable();
            $table->text('synopsis')->nullable();
            $table->decimal('film_budget', 10, 2)->nullable();
            $table->integer('film_length')->nullable();
            $table->integer('production_time')->nullable();
            $table->string('film_genre')->nullable();
            $table->string('film_type')->nullable();
            $table->decimal('premium_file_price', 10, 2)->nullable();
            $table->string('script_upload')->nullable();
            $table->string('contract_upload')->nullable();
            $table->string('trailer_upload')->nullable();
            $table->string('hd_fil_upload')->nullable();
            $table->string('sponsored_by')->nullable();
            $table->string('status')->default('pending');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creator_proposals');
    }
};
