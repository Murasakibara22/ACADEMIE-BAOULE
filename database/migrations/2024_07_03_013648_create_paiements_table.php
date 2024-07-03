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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->float('montant');
            $table->string('currency_code')->default('XOF');
            $table->string('type')->default('Mobile Money');
            $table->string('ref')->unique();
            $table->string('status');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->integer('taxes')->default(0);
            $table->integer('prix_initiale')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();

            $table->foreignId('customer_id')->nullable();
            $table->foreignId('abonnement_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
