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
        Schema::create('cours', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->text('description')->nullable();
            $table->string('langue')->default('français');
            $table->integer('nb_like')->default(0);
            $table->integer('nb_suivie')->default(0);
            $table->Time('nb_heures');
            $table->text('info_supp')->nullable();
            $table->string('link_short_video')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();

            $table->foreignId('parcours_id')->constrained('parcours')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cours');
    }
};
