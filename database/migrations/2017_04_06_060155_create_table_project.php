<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('No_Companies')->nullable();
            $table->string('Expected_Staff')->nullable();
            $table->date('Start_Date')->nullable();
            $table->date('Expected_date')->nullable();
            $table->string('brief_file')->nullable();
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
        Schema::drop('projects');
    }
}
