<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("partent_task_id")->nullable()->unsigned();
            $table->bigInteger("email_id")->unsigned();
            $table->string("subject");
            $table->longText("content");
            $table->text("attachment")->nullable();
            $table->longText("task_desc")->nullable();
            $table->text("remarks")->nullable();
            $table->datetime("start_datetime");
            $table->datetime("due_datetime")->nullable();
            $table->string("from_email");
            $table->bigInteger("account_contact_id")->nullable()->unsigned();
            $table->string("assignor");
            $table->string("assignee")->nullable();
            $table->string("type");
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
        Schema::dropIfExists('tasks');
    }
}
