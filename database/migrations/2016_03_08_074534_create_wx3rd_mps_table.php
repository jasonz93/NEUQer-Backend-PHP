<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWx3rdMpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wx3rd_mps', function (Blueprint $table) {
            $table->primary('app_id');
            $table->string('app_id');
            $table->bigInteger('user_id');
            $table->string('nickname');
            $table->string('avatar');
            $table->string('username');
            $table->string('alias');
            $table->string('qrcode_url');
            $table->string('access_token');
            $table->bigInteger('expires_at');
            $table->string('refresh_token');
            $table->integer('service_type');
            $table->integer('verify_type');
            $table->text('func_infos');
            $table->boolean('open_store');
            $table->boolean('open_scan');
            $table->boolean('open_pay');
            $table->boolean('open_card');
            $table->boolean('open_shake');
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
        Schema::drop('wx3rd_mps');
    }
}
