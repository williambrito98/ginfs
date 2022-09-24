<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("permissions_roles", function(Blueprint $table){
            $table->dropColumn("permission_id");
            $table->integer("permissions_id")->unsigned();
            $table->foreign("permissions_id")->references("id")->on("permissions")->onDelete("cascade");
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
        Schema::table("permissions_roles", function(Blueprint $table){
            $table->dropColumn("permissions_id");
            $table->dropColumn("roles_id");
        });
    }
}
