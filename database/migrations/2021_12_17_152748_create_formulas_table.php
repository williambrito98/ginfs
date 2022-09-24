<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormulasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formulas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->decimal('valor_minimo', 11, 2)->nullable();
            $table->decimal('valor_maximo', 11, 2)->nullable();
            $table->decimal('fator_redutor', 11, 2)->nullable();
            $table->decimal('indice', 3)->nullable();
            $table->decimal('iss_retido_das', 3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formulas');
    }
}
