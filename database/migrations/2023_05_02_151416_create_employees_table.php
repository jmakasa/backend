<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id')->unsigned()->autoIncrements();
            $table->integer('users_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->string('username')->nullable();
            $table->string('position')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string("status")->default('Active');
            $table->rememberToken();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->softDeletes();
            /**
             * ALTER TABLE `akasaweb2021`.`employees` 
ADD COLUMN `location` VARCHAR(10) NULL DEFAULT 'UK' AFTER `password`,
ADD COLUMN `lang` VARCHAR(10) NULL DEFAULT 'en' AFTER `location`;

             */
        });

        Schema::create('employee_departments', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('parent_id')->unsigned()->default(0);
            $table->string('name');
            $table->string('department_email')->nullable();
            $table->integer('head_id')->unsigned()->nullable();
            $table->string("status")->default('Active');
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('employee_in_departments', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('employees_id')->unsigned();
            $table->integer('employee_departments_id')->unsigned();
            $table->string('access_right');
            $table->string("status");
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('employee_settings', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('employees_id')->unsigned()->unique();
            $table->string('lang', 10)->default('en');
            $table->string('company', 10)->default('UK');
            $table->string('name_en');
            $table->string('name_cn')->nullable();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('employees');
        Schema::dropIfExists('employee_departments');
        Schema::dropIfExists('employee_in_departments');
        Schema::dropIfExists('employee_settings');
    }
}
