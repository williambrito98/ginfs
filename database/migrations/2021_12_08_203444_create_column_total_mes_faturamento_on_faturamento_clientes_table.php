<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColumnTotalMesFaturamentoOnFaturamentoClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn('faturamento_total');
        });

        Schema::table('faturamento_clientes', function (Blueprint $table) {
            $table->double('total_mes', 11, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->float('faturamento_total')->default(0);
        });

        Schema::table('faturamento_clientes', function (Blueprint $table) {
            $table->dropColumn('total_mes');
        });
    }
}
