<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIndiceAndIisRetidoFieldsOnFormulasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('formulas', function (Blueprint $table) {
            $table->dropColumn('indice');
            $table->dropColumn('iss_retido_das');
        });

        Schema::table('formulas', function (Blueprint $table) {
            $table->decimal('indice', 5, 2)->nullable();
            $table->decimal('iss_retido_das', 5, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('formulas', function (Blueprint $table) {
            $table->dropColumn('indice');
            $table->dropColumn('iss_retido_das');
        });

        Schema::table('formulas', function (Blueprint $table) {
            $table->decimal('indice', 3, 2)->nullable();
            $table->decimal('iss_retido_das', 3, 2)->nullable();
        });
    }
}
