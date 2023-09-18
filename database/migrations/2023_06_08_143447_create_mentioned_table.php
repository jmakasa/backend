<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMentionedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mentioned', function (Blueprint $table) {
            $table->increments('id')->unsigned()->autoIncrements();
            $table->integer('employees_id')->unsigned()->nullable();
            $table->string('type', 50);
            $table->integer('type_id')->unsigned()->nullable();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
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
        Schema::dropIfExists('mentioned');
    }
}
