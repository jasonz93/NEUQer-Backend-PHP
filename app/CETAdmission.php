<?php

namespace NEUQer;

use Illuminate\Database\Eloquent\Model;
use NEUQer\SDK\CET\CET99susheClient;
use Log;

class CETAdmission extends Model
{
    protected $table = 'cet_admissions';

    public function user() {
        return $this->belongsTo('NEUQer\User');
    }

    public function weixinUser() {
        return $this->belongsTo('NEUQer\WeixinUser');
    }

    public function score() {
        return $this->hasOne('NEUQer\CETScore', 'admission_id', 'id');
    }

    public function setNumber($number) {
        $this->number = $number;
        $this->exam_code = substr($number, 6, 3);
    }

    public function getScore() {
        if ($this->score != null) {
            return $this->score;
        }
        return $this->fetchScore();
    }

    public function fetchScore() {
        $client = new CET99susheClient();
        try {
            $result = $client->getScore($this->number, $this->name);
            $score = new CETScore();
            $score->admission()->associate($this);
            $score->name = $result['name'];
            $score->school = $result['school'];
            $score->type = $result['type'];
            $score->total = $result['total'];
            $score->listen = $result['listen'];
            $score->read = $result['read'];
            $score->write = $result['write'];
            $score->saveOrFail();
        } catch (\Exception $e) {
            $classname = get_class($e);
            Log::error("Error when fetching $this->name's score.");
            Log::error("Exception: $classname");
            Log::error("Message: {$e->getMessage()}");
            return null;
        }

        if ($this->weixinUser != null) {
            $config = CETConfig::find($this->weixinUser->mp->app_id);
            if ($config != null && $config->template_id != null) {
                try {
                    $this->weixinUser->sendTemplateMessage(route('cet.list', [
                        'mp' => $this->weixinUser->mp->app_id
                    ]),
                        $config->template_id,
                        [
                            'first' => [
                                'value' => "{$score->type}成绩新鲜出炉啦！\n",
                                'color' => '#000000'
                            ],
                            'keyword1' => [
                                'value' => $score->name,
                                'color' => '#173177'
                            ],
                            'keyword2' => [
                                'value' => $score->school,
                                'color' => '#173177'
                            ],
                            'keyword3' => [
                                'value' => $this->number,
                                'color' => '#173177'
                            ],
                            'keyword4' => [
                                'value' => "\n\t\t\t总分：$score->total\n\t\t\t听力：$score->listen\n\t\t\t阅读：$score->read\n\t\t\t写作翻译：$score->write",
                                'color' => '#173177'
                            ],
                            'remark' => [
                                'value' => $score->total >= 425 ?
                                    "\n恭喜你通过了{$score->type}考试，从此出任CEO，迎娶白富美，走上人生巅峰！" :
                                    "\n不好意思你没有通过{$score->type}考试，不要灰心，下半年再战！加油，NEUQer等着你！",
                                'color' => '#000000'
                            ]
                        ]);
                } catch (\Exception $e) {
                    $classname = get_class($e);
                    Log::error("$this->name has error $classname");
                    Log::error("Message: {$e->getMessage()}");
                }
            }
        }
        return $this->score = $score;
    }
}
