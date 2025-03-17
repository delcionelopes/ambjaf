<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',100);
            $table->string('email',100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password',100);
            $table->boolean('moderador');
            $table->string('avatar',150)->nullable();
            $table->string('link_instagram',150)->nullable();
            $table->string('link_facebook',150)->nullable();
            $table->rememberToken();
            $table->timestamp('created_at')->nullable()->useCurrent(); //alteramos o timestamps();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate(); //também
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
