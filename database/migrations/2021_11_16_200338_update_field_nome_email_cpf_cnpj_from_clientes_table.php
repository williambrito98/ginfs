<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFieldNomeEmailCpfCnpjFromClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn('nome');
            $table->dropColumn('email');
            $table->dropColumn('cpf');
            $table->dropColumn('cnpj');
            $table->string('cpf_cnpj', 14);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('nome', 60);
            $table->string('email', 60);
            $table->string('cpf', 11);
            $table->string('cnpj', 14);
            $table->dropColumn('cpf_cnpj');
        });
    }
}
