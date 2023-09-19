<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelatedFaqTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_related', function (Blueprint $table) {
            $table->increments("id");
            $table->uuid("product_id");
            $table->uuid("related_product_id");
            $table->string("status");
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign("product_id")->references("id")->on('product')->onDelete('cascade');
            $table->foreign("related_product_id")->references("id")->on('product')->onDelete('cascade');
        });

        Schema::create('web_template', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("name");
            $table->string("type");
            $table->string("status");
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('faq', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("product_id");
            $table->json("question");
            $table->json("anwser");
            $table->string("status");
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign("product_id")->references("id")->on('product')->onDelete('cascade');
        });

        Schema::create('product_review', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("product_id")->index();
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
            $table->foreign("product_id")->references("id")->on('product');
        });


        Schema::create('tag', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("parent_id")->nullable();
            $table->json("name");
            $table->string("status");
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('products_tags', function (Blueprint $table) {
            $table->increments("id");
            $table->uuid("product_id")->index();
            $table->uuid("tag_id")->index();
            $table->string("status");
            $table->timestamps();
            $table->foreign("product_id")->references("id")->on('product')->onDelete('cascade');
            $table->foreign("tag_id")->references("id")->on('tag')->onDelete('cascade');
        });

        Schema::create('file_uploads', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->json("name");
            $table->string("server_path");
            $table->string("mine_type")->nullable();
            $table->string("origninal_filename");
            $table->string("original_extension")->nullable();
            $table->string("type");
            $table->string("status");
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('nav_menu', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("category_id");
            $table->uuid("parent_id")->nullable();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->softDeletes();
            $table->timestamps();
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
        Schema::dropIfExists('web_template');
        Schema::dropIfExists('faq');
        Schema::dropIfExists('product_related');
        Schema::dropIfExists('product_review');
        Schema::dropIfExists('products_tags');
        Schema::dropIfExists('tag');
        Schema::dropIfExists('file_uploads');Schema::dropIfExists('nav_menu');
        /*
DROP TABLE product;
DROP TABLE products;
DROP TABLE menuses;
DROP TABLE product_sub;
DROP TABLE users;
DROP TABLE migrations;
DROP TABLE failed_jobs;
DROP TABLE password_resets;
DROP TABLE personal_access_tokens;
DROP TABLE faq;
DROP TABLE product_related;
DROP TABLE product_review;
DROP TABLE web_template;
DROP TABLE products_categorys;
DROP TABLE products_tags;
DROP TABLE tag;
DROP TABLE category;
DROP TABLE product;
        */
    }
}
