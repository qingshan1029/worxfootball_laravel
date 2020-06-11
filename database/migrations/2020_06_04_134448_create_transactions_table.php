<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->bigInteger('player_id');

            $table->bigInteger('match_id');     // match id(valid in case of reservation)

            $table->dateTime('datetime');       // event date

            $table->string('description');       // event date

            $table->string('event_name');     // event name 1 : charge, 2: reserved, 3: bonus(charge)

            $table->integer('amount');          // virtual money

            $table->integer('credit');          // real money(valid in case of charge(event_name = string) )

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
        Schema::dropIfExists('transactions');
    }
}
