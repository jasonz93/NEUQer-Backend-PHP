<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBbsTopicsAddFloors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bbs_topics', function (Blueprint $table) {
            $table->integer('floors');
        });
        DB::transaction(function () {
            $topics = \NEUQer\BBSTopic::all();
            foreach ($topics as $topic) {
                /** @var \NEUQer\BBSTopic $topic */
                $lastReply = $topic->lastReply;
                if ($lastReply == null) {
                    $topic->floors = 1;
                } else {
                    $topic->floors = $lastReply->floor + 1;
                }
                $topic->saveOrFail();
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
        Schema::table('bbs_topics', function (Blueprint $table) {
            $table->removeColumn('floors');
        });
    }
}
