<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->bigInteger("parent_tickets_id")->nullable()->unsigned();
            $table->bigInteger("email_id")->unsigned();
            $table->string("subject");
            $table->longText("content");
            $table->text("attachment")->nullable();
       //     $table->longText("internal_note")->nullable();
            $table->text("remarks")->nullable();
            $table->datetime("start_datetime");
            $table->datetime("due_datetime")->nullable();
            $table->string("from_email");
            $table->bigInteger("account_contact_id")->nullable()->unsigned();
            $table->string("assignor")->nullable();
            $table->string("assignee")->nullable();
            $table->string("type");
            $table->string("status")->default('Active');
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();


            
        });

        Schema::create('ticket_internal_notes', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->bigInteger("tickets_id")->nullable()->unsigned();
            $table->longText("content");
            $table->text("attachment")->nullable();
       //     $table->longText("internal_note")->nullable();
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
        Schema::dropIfExists('tickets');
    }
}
