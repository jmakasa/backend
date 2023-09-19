<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRelationshipTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::table('products_categorys', function(Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['category_id']);
            $table->renameColumn('product_id', 'products_id');
            $table->renameColumn('category_id', 'categorys_id');
            $table->foreign("products_id")->references("id")->on('products')->onDelete('cascade');
    
        });

        Schema::table('products_tags', function(Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['tag_id']);
            $table->renameColumn('product_id', 'products_id');
            $table->renameColumn('tag_id', 'tags_id');
            $table->foreign("products_id")->references("id")->on('products')->onDelete('cascade');
            $table->foreign("tags_id")->references("id")->on('tags')->onDelete('cascade');
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
