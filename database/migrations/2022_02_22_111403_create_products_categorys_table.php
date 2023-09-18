<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsCategorysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_categorys', function (Blueprint $table) {
            $table->increments("id");
            $table->uuid("product_id")->nullable(false);
            $table->uuid("category_id")->nullable(false);
            $table->foreign("product_id")->references("id")->on('product')->onDelete('cascade');
            $table->foreign("category_id")->references("id")->on('category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_categorys');
    }
}
