<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublishClientAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publish_client_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('publish_id')->unsigned();
            $table->foreign('publish_id')->references('id')->on('publish');
            $table->integer('client_account_id')->unsigned();
            $table->foreign('client_account_id')->references('id')->on('client_accounts');
            $table->boolean('published')->default(0);
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
        Schema::dropIfExists('publish_client_accounts');
    }
}
