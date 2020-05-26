<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();

            $table->string('host_photo');

            $table->string('host_name');

            $table->string('title');

            $table->datetime('start_time')->nullable();

            $table->string('address')->nullable();

            $table->double('latitude');

            $table->double('longitude');

            $table->integer('rules');

            $table->integer('reservations');

            $table->boolean('active')->default(true);

            $table->double('radius');

            $table->integer('credits');

            $table->timestamps();

            $table->softDeletes();

            $table->index(['deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
