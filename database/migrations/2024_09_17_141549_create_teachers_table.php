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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyText('country');
            $table->tinyText('subject');
            $table->longText('description');
            $table->string('image');
            $table->string('video');
            $table->integer('CostHour');
            $table->string('phone')->unique();
            $table->integer('verification_code')->nullable();
            $table->enum('status', ['Active','Rejected'])->default('Active');
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
