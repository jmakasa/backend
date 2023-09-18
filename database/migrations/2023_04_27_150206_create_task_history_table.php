<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('task_history', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->bigInteger("task_id")->unsigned();
            $table->bigInteger("partent_task_id")->nullable()->unsigned();
            $table->bigInteger("email_id")->unsigned();
            $table->string("subject");
            $table->longText("content");
            $table->text("attachment")->nullable();
            $table->longText("task_desc")->nullable();
            $table->text("remarks")->nullable();
            $table->datetime("start_datetime");
            $table->datetime("due_datetime")->nullable();
            $table->string("from_firstname");
            $table->string("from_lastname");
            $table->string("from_email");
            $table->bigInteger("account_contact_id")->nullable()->unsigned();
            $table->string("assignor");
            $table->string("assignee")->nullable();
            $table->string("type");
            $table->string("status");
            $table->string("change_type");
            $table->longText("change_value");
            $table->string("created_by")->nullable();
            $table->timestamps();
            $table->index(['id','task_id','change_type']);
        });
        Schema::create('task_threads_history', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->bigInteger("task_threads_id")->unsigned();
            $table->bigInteger("task_id")->unsigned();
            $table->string("subject");
            $table->longText("content");
            $table->longText("content_language",50);
            $table->longText("content_type",50);
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
            $table->string("change_type");
            $table->longText("change_value");
            $table->timestamps();
            $table->index(['id','task_id','task_threads_id','change_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_history');
        Schema::dropIfExists('task_threads_history');
    }
}
