<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('email')->unique();

            $table->string('password');

            $table->string('first_name');

            $table->string('last_name');

            $table->date('birthday');

            $table->string('photo');

            $table->integer('credits');     // virtual money

            $table->integer('status');  // 0: pending, 1: active, 2: logout, 3: delete

            $table->timestamps();

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
        Schema::dropIfExists('players');
    }
}
