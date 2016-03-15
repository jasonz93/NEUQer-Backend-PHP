<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->text('banner')->nullable();
            $table->text('icon')->nullable();
            $table->text('title');
            $table->text('subtitle');
            $table->string('type', 8);
            $table->text('param');
            $table->bigInteger('author_id');
            $table->integer('position');
            $table->boolean('is_banner');
            $table->boolean('show');
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
        Schema::drop('home_messages');
    }
}
