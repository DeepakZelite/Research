<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id')->nullable();
            $table->string('user_id')->nullable();
            $table->string('salutation')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('job_title')->nullable();
            $table->string('specialization')->nullable();
            $table->string('staff_source')->nullable();
            $table->string('staff_email')->nullable();
            $table->string('direct_phoneno')->nullable();
            $table->string('email_source')->nullable();
            $table->string('qualification')->nullable();
            $table->string('staff_disposition')->nullable();
            $table->string('deparment_number')->nullable();
            $table->string('alternate_phone')->nullable();
            $table->string('alternate_email')->nullable();
            $table->string('email_type')->nullable();
            $table->string('shift_timing')->nullable();
            $table->string('working_tenure')->nullable();
            $table->string('paternership')->nullable();
            $table->string('age')->nullable();
            $table->string('staff_remarks')->nullable();
            $table->string('additional_info1')->nullable();
            $table->string('additional_info2')->nullable();
            $table->string('additional_info3')->nullable();
            $table->string('additional_info4')->nullable();
            $table->tinyInteger('removable')->default('1');
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
        Schema::drop('contacts');
    }
}
