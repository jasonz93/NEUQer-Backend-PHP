<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBBSTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bbs_topics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('board_id');
            $table->bigInteger('user_id');
            $table->string('title');
            $table->text('content');
            $table->text('pictures');
            $table->integer('view_count');
            $table->dateTime('last_reply_time');
            $table->bigInteger('last_reply_user_id');
            $table->string('oldid', 24);
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
        Schema::drop('bbs_topics');
    }
}
