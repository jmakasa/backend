<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_threads', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("task_id")->unsigned();
            $table->string("subject");
            $table->longText("content");
            $table->longText("content_language",50)->nullable();
            $table->longText("content_type",50)->nullable();
            $table->text("attachment")->nullable();
            $table->integer("attachment_cnt")->unsigned()->default(0);
            $table->longText("task_desc")->nullable();
            $table->text("to_email");
            $table->string("to_cc")->nullable();
            $table->string("to_bcc")->nullable();
            $table->string("from_email");
            $table->bigInteger("account_contact_id")->nullable()->unsigned();
            $table->datetime("sent_datetime")->nullable();
            $table->string("message_id")->nullable();
            $table->string("status");
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
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
        Schema::dropIfExists('task_threads');
    }
}
