<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCetAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cet_admissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('exam_code', 3);
            $table->bigInteger('user_id');
            $table->bigInteger('weixin_user_id');
            $table->string('number', 20);
            $table->string('name', 20);
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
        Schema::drop('cet_admissions');
    }
}
