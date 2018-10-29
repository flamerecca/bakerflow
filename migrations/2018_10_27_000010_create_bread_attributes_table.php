<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBreadAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bread_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bread_entity_id')->unsigned();
            $table->string('attribute');
            $table->string('type');
            $table->boolean('required')->default(false);
            $table->text('example')->nullable();
            $table->text('details')->nullable();
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
        Schema::dropIfExists('bread_attributes');
    }
}
