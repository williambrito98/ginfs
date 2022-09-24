<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaFiscalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('notas');

        Schema::create('nota_fiscal', function (Blueprint $table) {
            $table->id();
            $table->decimal('valor');
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreignId('tomador_id')->references('id')->on('tomadores');
            $table->foreignId('status_nota_fiscal_id')->references('id')->on('status_nota_fiscal');
            $table->timestamp('data_emissao')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nota_fiscal');

        Schema::create('notas', function (Blueprint $table) {
            $table->id();
            $table->float('valor');
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->timestamps();
        });
    }
}
