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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('name');
            $table->string('dial_code')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('phone')->unique();
            $table->string('email')->nullable();
            $table->string('gender')->nullable();
            $table->string('photo_url')->nullable();
            $table->string('password')->nullable();
            $table->integer('code_generate')->unique()->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('google_id')->nullable();
            $table->string('slug')->unique();
            $table->Boolean('as_partenaire')->nullable();
            $table->foreignId('partenaire_id')->nullable();
            $table->json('CentreInterets')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
