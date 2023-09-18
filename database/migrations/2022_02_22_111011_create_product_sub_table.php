<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sub', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("product_id");
            $table->json("product_code")->index();
            $table->json("name")->index();
            $table->json("desc")->index();
            $table->string("status");
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign("product_id")->references("id")->on('product')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_sub');
    }
}
