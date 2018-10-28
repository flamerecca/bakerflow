<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBreadEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bread_entities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('database_name')->unique();
            $table->string('route')->unique();
            $table->string('entity_class')->nullable();
            $table->string('description')->nullable();
            $table->string('connection')->nullable();
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
        Schema::dropIfExists('bread_entities');
    }
}
