<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedAtToCuadrillasTable extends Migration
{
    public function up()
    {
        Schema::table('cuadrillas', function (Blueprint $table) {
            $table->softDeletes(); // Añade el campo deleted_at
        });
    }

    public function down()
    {
        Schema::table('cuadrillas', function (Blueprint $table) {
            $table->dropSoftDeletes(); // Elimina el campo deleted_at
        });
    }
}
