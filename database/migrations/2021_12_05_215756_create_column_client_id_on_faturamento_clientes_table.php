<?php

use App\Models\Clientes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColumnClientIdOnFaturamentoClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('faturamento_clientes', function (Blueprint $table) {
            $table->foreignIdFor(Clientes::class);
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
            $table->dropForeign('faturamento_clientes_clientes_id_foreign');
        });
    }
}
