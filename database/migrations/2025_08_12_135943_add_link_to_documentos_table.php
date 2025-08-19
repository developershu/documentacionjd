<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('documentos', function (Blueprint $table) {
            $table->string('link')->nullable()->after('estado'); // o después del campo que prefieras
        });
    }


    /**
     * Reverse the migrations.
     */

    public function down()
    {
        Schema::table('documentos', function (Blueprint $table) {
            $table->dropColumn('link');
        });
    }
};
