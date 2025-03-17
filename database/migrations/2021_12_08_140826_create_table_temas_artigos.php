<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTemasArtigos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temas_artigos', function (Blueprint $table) {
            $table->unsignedBigInteger('artigos_id');
            $table->unsignedBigInteger('temas_id');
 
            $table->foreign('artigos_id')->references('id')->on('artigos');
            $table->foreign('temas_id')->references('id')->on('temas'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temas_artigos');
    }
}
