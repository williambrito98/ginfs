<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveFieldsEmissaoDataCadastroFromTomadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tomadores', function (Blueprint $table) {
            $table->dropColumn('emissao');
            $table->dropColumn('data_cadastro');
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
            $table->date('emissao');
            $table->date('data_cadastro');
        });
    }
}
