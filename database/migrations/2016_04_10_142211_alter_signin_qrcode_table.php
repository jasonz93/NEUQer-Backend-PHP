<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSigninQrcodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('signin_qrcode', function(Blueprint $table){
           $table->renameColumn('user_id', 'admission_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('signin_qrcode', function(Blueprint $table){
            $table->renameColumn('admission_id', 'user_id');
        });
    }
}
