<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expedientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cita_id')->unique()->constrained('citas')->onDelete('cascade');
            $table->text('diagnostico');
            $table->text('receta_medica')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expedientes');
    }
};