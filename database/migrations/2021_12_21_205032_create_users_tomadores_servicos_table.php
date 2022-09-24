<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTomadoresServicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_tomadores_servicos', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('tomadores_id');
            $table->unsignedBigInteger('servicos_id');
            $table->char('indicador_ativo', 1)->default('S');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('tomadores_id')->references('id')->on('tomadores');
            $table->foreign('servicos_id')->references('id')->on('servicos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_tomadores_servicos');
    }
}
