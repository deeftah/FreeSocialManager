<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeletes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('publish', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('publish_client_accounts', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('tags', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('tag_groups', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('publish', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('publish_client_accounts', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('tag_groups', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
    }
}
