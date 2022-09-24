<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTomadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tomadores', function (Blueprint $table) {
            $table->id();
            $table->string('cnpj');
            $table->string('cpf');
            $table->date('emissao');
            $table->date('data_cadastro');
            $table->string('inscricao_municipal')->nullable();
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
        Schema::dropIfExists('tomadores');
    }
}
