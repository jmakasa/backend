<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->json("title");
            $table->json("subtitle");
            $table->json("content");
            $table->date("display_date");
            $table->string("type");
            $table->string("status");
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('products_blogs', function (Blueprint $table) {
            $table->increments("id");
            $table->uuid("products_id")->index();
            $table->uuid("blogs_id")->index();
            $table->string("status");
            $table->timestamps();
            $table->foreign("products_id")->references("id")->on('products')->onDelete('cascade');
            $table->foreign("blogs_id")->references("id")->on('blogs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
