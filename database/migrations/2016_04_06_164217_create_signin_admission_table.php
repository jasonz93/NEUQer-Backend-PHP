<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSigninAdmissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signin_admission', function(Blueprint $table){
            $table->increments('id');
            $table->bigInteger('user_id');
            $table->bigInteger('weixin_user_id');
            $table->integer('stu_id');
            $table->string('name');
            $table->index(['user_id','stu_id']);
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
        Schema::drop('signin_admission');
    }
}
