<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnsValorFatExtAndValorFaturamentoOnFaturamentoClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('faturamento_clientes', function (Blueprint $table) {
            $table->dropColumn('valor_faturamento_externo');
            $table->dropColumn('valor_faturamento');
        });

        Schema::table('faturamento_clientes', function (Blueprint $table) {
            $table->decimal('valor_faturamento_externo', 11, 2)->nullable();
            $table->decimal('valor_faturamento', 11, 2)->nullable();
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
            $table->dropColumn('valor_faturamento_externo');
            $table->dropColumn('valor_faturamento');
        });

        Schema::table('faturamento_clientes', function (Blueprint $table) {
            $table->double('valor_faturamento_externo', 11, 2)->nullable();
            $table->double('valor_faturamento', 11, 2)->nullable();
        });
    }
}
