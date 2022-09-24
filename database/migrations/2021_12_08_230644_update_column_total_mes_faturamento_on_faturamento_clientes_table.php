<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnTotalMesFaturamentoOnFaturamentoClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('faturamento_clientes', function (Blueprint $table) {
            $table->dropColumn('total_mes');
        });

        Schema::table('faturamento_clientes', function (Blueprint $table) {
            $table->decimal('total_mes', 11, 2)->nullable();
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
            $table->dropColumn('total_mes');
        });

        Schema::table('faturamento_clientes', function (Blueprint $table) {
            $table->double('total_mes', 11, 2)->nullable();
        });
    }
}
