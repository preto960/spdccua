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
        Schema::create('cuadrilla_empleado', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cuadrilla_id');
            $table->unsignedBigInteger('empleado_id');
            $table->timestamps();

            $table->foreign('cuadrilla_id')->references('id')->on('cuadrillas')->onDelete('cascade');
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');
            $table->unique(['cuadrilla_id', 'empleado_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuadrilla_empleado');
    }
};
