<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRelationshipTables2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('product_reviews');
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("products_id")->index();
            $table->json("title");
            $table->json("desc");
            $table->json("content");
            $table->timestamp("display_date");
            $table->string("company");
            $table->string("author")->nullable();
            $table->string("link");
            $table->string("type")->index();
            $table->string("status")->index();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign("products_id")->references("id")->on('products');
        });
        Schema::dropIfExists('faqs');
        Schema::create('faqs', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("products_id");
            $table->json("question");
            $table->json("anwser");
            $table->string("status");
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign("products_id")->references("id")->on('products')->onDelete('cascade');
        });
		
        Schema::dropIfExists('product_subs');
        Schema::create('product_subs', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("products_id");
            $table->json("product_code")->index();
            $table->json("name")->index();
            $table->json("desc")->index();
            $table->string("status");
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign("products_id")->references("id")->on('products')->onDelete('cascade');
        });
        Schema::dropIfExists('product_relateds');
        Schema::create('product_relateds', function (Blueprint $table) {
            $table->increments("id");
            $table->uuid("products_id");
            $table->uuid("related_products_id");
            $table->string("status");
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign("products_id")->references("id")->on('products')->onDelete('cascade');
            $table->foreign("related_products_id")->references("id")->on('products')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
