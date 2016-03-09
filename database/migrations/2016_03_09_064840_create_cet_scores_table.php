<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCetScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cet_scores', function (Blueprint $table) {
            $table->primary('admission_id');
            $table->bigInteger('admission_id');
            $table->integer('total');
            $table->integer('listen');
            $table->integer('read');
            $table->integer('write');
            $table->string('school');
            $table->string('type');
            $table->string('name');
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
        Schema::drop('cet_scores');
    }
}
