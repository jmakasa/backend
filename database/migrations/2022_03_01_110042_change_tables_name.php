<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTablesName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::rename('product', 'products');
        Schema::rename('faq', 'faqs');
        Schema::rename('product_review', 'product_reviews');
        Schema::rename('product_related', 'product_relateds');
        Schema::rename('nav_menu', 'nav_menus');
        Schema::rename('product_sub', 'product_subs');
        Schema::rename('tag', 'tags');
        Schema::rename('web_template', 'web_templates');


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
