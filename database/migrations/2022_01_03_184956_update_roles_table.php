<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("roles_user", function(Blueprint $table){
            $table->dropColumn("role_id");
            $table->integer("roles_id")->unsigned();
            $table->foreign("roles_id")->references("id")->on("roles")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("roles_user", function(Blueprint $table){
            $table->dropColumn("roles_id");
        });
    }
}
