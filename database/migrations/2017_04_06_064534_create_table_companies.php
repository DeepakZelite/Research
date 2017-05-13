<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('batch_id')->nullable();
            $table->string('sub_batch_id')->nullable();
            $table->string('user_id')->nullable();
            $table->string('status')->nullable();
            $table->string('company_instructions',64000)->nullable();
            $table->string('company_id')->nullable();
            $table->unsignedInteger('parent_id');
            $table->string('parent_company')->nullable();
            $table->string('company_name',64000)->nullable();
            $table->string('updated_company_name',64000)->nullable();
            $table->string('address1',64000)->nullable();
            $table->string('address2',64000)->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('country')->nullable();
            $table->string('isd_code')->nullable();
            $table->string('switchboardnumber',64000)->nullable();
            $table->string('branchNumber',64000)->nullable();
            $table->string('addresscode',64000)->nullable();
            $table->string('website',64000)->nullable();
            $table->string('company_email',64000)->nullable();
            $table->string('products_services',64000)->nullable();
            $table->string('industry_classfication',64000)->nullable();
            $table->string('employee_size')->nullable();
            $table->string('physician_size')->nullable();
            $table->string('annual_revenue')->nullable();
            $table->string('number_of_beds')->nullable();
            $table->string('foundation_year')->nullable();
            $table->string('company_remark',64000)->nullable();
            $table->string('additional_info1',64000)->nullable();
            $table->string('additional_info2',64000)->nullable();
            $table->string('additional_info3',64000)->nullable();
            $table->string('additional_info4',64000)->nullable();
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
        Schema::drop('companies');
    }
}
