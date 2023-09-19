<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("parent_id")->nullable();
            $table->json("name");
            $table->string("seq")->nullable();
            $table->string("type");
            $table->string("status");
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('category');
    }
}
