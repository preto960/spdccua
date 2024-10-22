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
        Schema::table('trabajo_secretaria', function (Blueprint $table) {
            $table->date('fecha_desde')->nullable();  // Campo fecha desde
            $table->date('fecha_hasta')->nullable();  // Campo fecha hasta
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trabajo_secretaria', function (Blueprint $table) {
            $table->dropColumn(['fecha_desde', 'fecha_hasta']);
        });
    }
};
