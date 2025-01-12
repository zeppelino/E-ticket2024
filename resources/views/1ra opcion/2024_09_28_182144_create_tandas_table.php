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
        Schema::create('tandas', function (Blueprint $table) {
            $table->foreignId('idEvento')->constrained('eventos','idEvento');
            $table->id('idTanda');
            $table->string('nombreTanda');
            $table->timestamp('fechaInicio')->nullable();
            $table->timestamp('fechaFin')->nullable();
            $table->integer('cupos');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tandas');
    }
};
