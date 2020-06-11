<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        date_default_timezone_set('Europe/London');

        Schema::create('bonuses', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->boolean('active');          // active status

            $table->dateTime('from_date');      //  starting date

            $table->dateTime('to_date');        // end date

            $table->integer('amount');          // bonus(virtual money)

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
        Schema::dropIfExists('bonuses');
    }
}
