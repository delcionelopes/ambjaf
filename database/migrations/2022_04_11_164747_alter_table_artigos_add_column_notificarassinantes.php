<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableArtigosAddColumnNotificarassinantes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('artigos', function (Blueprint $table) {
            $table->boolean('notificarassinantes')->nullable()->after('imagem');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('artigos', function (Blueprint $table) {
            //
        });
    }
}
