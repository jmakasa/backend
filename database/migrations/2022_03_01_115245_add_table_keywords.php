<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableKeywords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keywords', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("parent_id")->nullable();
            $table->json("name");
            $table->json("display_name");
            $table->string("seq")->nullable();
            $table->string("status")->index();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('products_keywords', function (Blueprint $table) {
            $table->increments("id");
            $table->uuid("products_id")->index();
            $table->uuid("keywords_id")->index();
            $table->string("status");
            $table->timestamps();
            $table->foreign("products_id")->references("id")->on('products')->onDelete('cascade');
            $table->foreign("keywords_id")->references("id")->on('keywords')->onDelete('cascade');
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
