<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColumnsQuantidadeEmissoesAndEncerradoFaturamentoOnFaturamentoClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('faturamento_clientes', function (Blueprint $table) {
            $table->integer('quantidade_emissoes')->nullable();
            $table->char('encerrado', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('faturamento_clientes', function (Blueprint $table) {
            $table->dropColumn('quantidade_emissoes');
            $table->dropColumn('encerrado');
        });
    }
}
