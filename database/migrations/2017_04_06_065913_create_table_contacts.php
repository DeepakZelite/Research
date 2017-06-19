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
            $table->string('job_title',64000)->nullable();
            $table->string('specialization',64000)->nullable();
            $table->string('staff_source',64000)->nullable();
            $table->string('staff_email',64000)->nullable();
            $table->string('direct_phoneno',64000)->nullable();
            $table->string('email_source',64000)->nullable();
            $table->string('qualification',64000)->nullable();
            $table->string('staff_disposition',64000)->nullable();
            $table->string('deparment_number',64000)->nullable();
            $table->string('alternate_phone',64000)->nullable();
            $table->string('alternate_email',64000)->nullable();
            $table->string('email_type')->nullable();
            $table->string('shift_timing')->nullable();
            $table->string('working_tenure')->nullable();
            $table->string('paternership')->nullable();
            $table->string('age')->nullable();
            $table->string('staff_remarks',64000)->nullable();
            $table->string('additional_info1',64000)->nullable();
            $table->string('additional_info2',64000)->nullable();
            $table->string('additional_info3',64000)->nullable();
            $table->string('additional_info4',64000)->nullable();
            $table->string('additional_info5',64000)->nullable();
            $table->string('additional_info6',64000)->nullable();
            $table->string('additional_info7',64000)->nullable();
            $table->string('additional_info8',64000)->nullable();
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
