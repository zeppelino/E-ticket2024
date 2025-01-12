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
        Schema::create('beneficios', function (Blueprint $table) {
            $table->id('idBeneficio');
            $table->integer('porcentaje');
            $table->timestamp('fechaInicioBeneficio')->nullable();
            $table->timestamp('fechaFinBeneficio')->nullable();
            $table->foreignId('idEvento')->constrained('eventos','idEvento')->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficios');
    }
};
