<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDocumentoIdToComentariosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::table('comentarios', function (Blueprint $table) {
            // Añadir la columna con valor por defecto 1 para registros existentes
            $table->unsignedBigInteger('documento_id')->default(1)->after('id');
            
            // Convertirla en llave foránea
            $table->foreign('documento_id')
                  ->references('id')
                  ->on('documentos')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comentarios', function (Blueprint $table) {
            $table->dropForeign(['documento_id']);
            $table->dropColumn('documento_id');
        });
    }
};
