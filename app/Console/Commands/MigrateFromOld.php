<?php

namespace NEUQer\Console\Commands;

use Illuminate\Console\Command;
use DB;
use NEUQer\CETAdmission;
use NEUQer\CETScore;
use NEUQer\User;
use NEUQer\WeixinUser;
use NEUQer\Wx3rdMP;

class MigrateFromOld extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate from old instance';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::transaction(function () {
            $mp = Wx3rdMP::findOrFail('wxa1a6701c72bf29e1');
            $oldWeixinUsers = DB::connection('old')->select('select * from `neuqer_wx3rd_wxuser`');
            foreach ($oldWeixinUsers as $oldWeixinUser) {
                $user = User::create([
                    'nickname' => $oldWeixinUser->nickname,
                    'password' => bcrypt($oldWeixinUser->open_id)
                ]);
                $weixinUser = new WeixinUser();
                $weixinUser->user()->associate($user);
                $weixinUser->nickname = $oldWeixinUser->nickname;
                $weixinUser->openid = $oldWeixinUser->open_id;
                $weixinUser->unionid = $oldWeixinUser->union_id;
                $weixinUser->avatar = $oldWeixinUser->avatar;
                $weixinUser->mp()->associate($mp);
                $weixinUser->saveOrFail();

                $oldAdmission = DB::connection('old')->selectOne('select * from neuqer_cet_admission where wx_user_id = :id', [
                    'id' => $oldWeixinUser->id
                ]);
                if ($oldAdmission == null) {
                    continue;
                }
                $oldScore = DB::connection('old')->selectOne('select * from neuqer_cet_score where admission_id = :id', [
                    'id' => $oldAdmission->id
                ]);
                $admission = new CETAdmission();
                $admission->weixinUser()->associate($weixinUser);
                $admission->user()->associate($user);
                $admission->name = $oldAdmission->name;
                $admission->setNumber($oldAdmission->number);
                $admission->saveOrFail();
                if ($oldScore != null) {
                    $score = new CETScore();
                    $score->admission()->associate($admission);
                    $score->school = $oldScore->school;
                    $score->type = $oldScore->type;
                    $score->name = $oldScore->name;
                    $score->total = $oldScore->s_total;
                    $score->listen = $oldScore->s_listen;
                    $score->read = $oldScore->s_read;
                    $score->write = $oldScore->s_write;
                    $score->saveOrFail();
                }
            }
        });
    }
}
