<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColumnMesAnoFaturamentoOnFaturamentoClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('faturamento_clientes', function (Blueprint $table) {
            $table->dropColumn('mes_faturamento');
            $table->string('mes_ano_faturamento', 255);
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
            $table->date('mes_faturamento');
            $table->dropColumn('mes_ano_faturamento');
        });
    }
}
