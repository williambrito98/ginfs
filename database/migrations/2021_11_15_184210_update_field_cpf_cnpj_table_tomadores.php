<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFieldCpfCnpjTableTomadores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tomadores', function (Blueprint $table) {
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
        Schema::table('tomadores', function (Blueprint $table) {
            $table->string('cpf', 11);
            $table->string('cnpj', 14);
            $table->dropColumn('cpf_cnpj');
        });
    }
}
