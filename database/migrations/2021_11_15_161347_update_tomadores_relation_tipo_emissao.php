<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTomadoresRelationTipoEmissao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tomadores', function (Blueprint $table) {
            $table->unsignedBigInteger('tipo_emissaos_id')->nullable();
            $table->foreign('tipo_emissaos_id')->references('id')->on('tipo_emissaos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tomadores', function (Blueprint $table) {
            $table->dropColumn('tipo_emissaos_id');
        });
    }
}
