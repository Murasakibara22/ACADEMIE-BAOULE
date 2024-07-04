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
        Schema::create('cours_follows', function (Blueprint $table) {
            $table->id();
            $table ->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table ->foreignId('cours_id')->constrained('cours')->onDelete('cascade');
            $table->integer('progession')->default(5);
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cours_follows');
    }
};
