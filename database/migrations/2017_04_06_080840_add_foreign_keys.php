<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('set null');
        });

        Schema::table('social_logins', function(Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::table('user_social_networks', function(Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::table('companies', function(Blueprint $table) {
            $table->foreign('batch_id')
                ->references('id')
                ->on('batches')
                ->onDelete('cascade');
        });

        Schema::table('contacts', function(Blueprint $table) {
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropForeign('users_country_id_foreign');
        });

        Schema::table('social_logins', function(Blueprint $table) {
            $table->dropForeign('social_logins_user_id_foreign');
        });

        Schema::table('user_social_networks', function(Blueprint $table) {
            $table->dropForeign('user_social_networks_user_id_foreign');
        });
        Schema::table('companies', function(Blueprint $table) {
            $table->dropForeign('companies_batch_id_foreign');
        });
        Schema::table('contacts', function(Blueprint $table) {
            $table->dropForeign('contacts_company_id_foreign');
        });
    }
}
