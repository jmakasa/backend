<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->json("title");
            $table->json("name");
            $table->json("product_code")->index();
            $table->json("web_settings");
            $table->json("web_available");
            $table->json("intro")->nullable();
            $table->json("desc")->nullable();
            $table->json("long_desc")->nullable();
            $table->json("spec")->nullable();
            $table->json("seq")->nullable();
            $table->string("type")->index();
            $table->string("status")->index();
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
        Schema::dropIfExists('product');
    }
}
