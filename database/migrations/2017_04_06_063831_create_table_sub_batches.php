<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSubBatches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_batches', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('vendor_id');
            $table->string('name')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('batch_id')->nullable();
            $table->string('company_count')->nullable();
            $table->string('status')->nullable();
            $table->unsignedInteger('seq_no')->nullable();
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
        Schema::drop('sub_batches');
    }
}
