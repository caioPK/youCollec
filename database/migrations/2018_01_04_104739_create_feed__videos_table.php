<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(/**
         * @param Blueprint $table
         */
            'feed__videos', function (Blueprint $table) {
            $table->string('idVideo');
            $table->integer('idUser')->unsigned();
            $table->integer('idCat')->unsigned();
            $table->boolean('assistido');
            $table->integer('idCanal')->unsigned();
            $table->increments('id');

            $table->foreign('idUser')->references('id')->on('users');
            $table->foreign('idCat')->references('idCat')->on('collections');
            $table->foreign('idCanal')->references('idCanal')->on('channels');

            $table->unique(['idVideo', 'idUser'], 'index_videos');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feed__videos');
    }
}
