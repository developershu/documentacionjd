<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstadoToDocumentosTable extends Migration
{
    public function up()
    {
        Schema::table('documentos', function (Blueprint $table) {
            $table->string('estado')->default('borrador')->after('archivo');
        });
    }

    public function down()
    {
        Schema::table('documentos', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
}
