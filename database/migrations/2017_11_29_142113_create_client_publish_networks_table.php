<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientPublishNetworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publish_networks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('publish_id')->unsigned();
            $table->foreign('publish_id')->references('id')->on('publish');
            $table->integer('network_id')->unsigned();
            $table->foreign('network_id')->references('id')->on('networks');
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
        Schema::dropIfExists('publish_networks');
    }
}
