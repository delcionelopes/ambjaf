<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableArtigos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artigos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo',100);
            $table->string('descricao',180);
            $table->text('conteudo');
            $table->string('slug',150)->nullable();
            $table->string('imagem',150)->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();        

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('artigos',function(Blueprint $table){  
            $table->dropForeign(['user_id']);
            });    
        Schema::dropIfExists('artigos');
    }
}
