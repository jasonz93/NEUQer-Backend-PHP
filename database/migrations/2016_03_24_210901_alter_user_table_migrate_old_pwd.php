<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUserTableMigrateOldPwd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('oldpwd', 32)->nullable();
        });
        DB::transaction(function () {
            $users = \NEUQer\User::all();
            foreach ($users as $user) {
                if (strlen($user->password) === 32) {
                    $user->oldpwd = $user->password;
                    $user->password = '';
                    $user->save();
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->removeColumn('oldpwd');
        });
    }
}
