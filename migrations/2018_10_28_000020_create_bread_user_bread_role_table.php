<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBreadUserBreadRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bread_user_bread_role', function (Blueprint $table) {
            $table->integer('bread_user_id')->unsigned()->index();
            $table->foreign('bread_user_id')->references('id')->on('bread_users')->onDelete('cascade');
            $table->integer('bread_role_id')->unsigned()->index();
            $table->foreign('bread_role_id')->references('id')->on('bread_roles')->onDelete('cascade');
            $table->primary(['bread_user_id', 'bread_role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bread_user_bread_role');
    }
}
