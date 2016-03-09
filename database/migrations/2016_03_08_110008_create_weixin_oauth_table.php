<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeixinOauthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weixin_oauth', function (Blueprint $table) {
            $table->primary(['weixin_user_id', 'scope']);
            $table->bigInteger('weixin_user_id');
            $table->string('scope');
            $table->string('access_token');
            $table->string('refresh_token');
            $table->bigInteger('expires_at');
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
        Schema::drop('weixin_oauth');
    }
}
