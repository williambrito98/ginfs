<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFieldTomadorIdFromUsersTomadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_tomadores', function (Blueprint $table) {
            $table->dropColumn('tomador_id');
            $table->unsignedBigInteger('tomadores_id')->nullable();
            $table->foreign('tomadores_id')->references('id')->on('tomadores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_tomadores', function (Blueprint $table) {
            $table->dropColumn('tomadores_id');
            $table->unsignedBigInteger('tomador_id')->nullable();
            $table->foreign('tomador_id')->references('id')->on('tomadores');
        });
    }
}
