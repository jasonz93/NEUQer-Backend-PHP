<?php

namespace NEUQer;

use Illuminate\Database\Eloquent\Model;
use Carbon;

class BBSTopic extends Model
{
    protected $table = 'bbs_topics';
    protected $dates = ['created_at', 'updated_at'];

    public function user() {
        return $this->belongsTo('NEUQer\User');
    }

    public function board() {
        return $this->belongsTo('NEUQer\BBSBoard');
    }

    public function lastReply() {
        return $this->belongsTo('NEUQer\BBSReply', 'last_reply_id', 'id');
    }

    public function likes() {
        return $this->morphMany('NEUQer\BBSLike', 'likeable');
    }

    public function removed() {
        return $this->morphOne('NEUQer\BBSOperation', 'entity');
    }

    public function setPictures(array $pictures) {
        $this->pictures = json_encode($pictures);
        return $this;
    }

    public static function getLatest($per, $page) {
        return self::doesntHave('removed')
            ->limit($per)
            ->offset($per * ($page - 1))
            ->get();
    }

    public function toArray()
    {
        return [
            'id' => strval($this->id),
            '_id' => strval($this->id),
            'user' => strval($this->user->id),
            'userBrief' => $this->getUserBrief(),
            'tags' => [
                $this->board->name
            ],
            'title' => $this->title,
            'content' => $this->content,
            'pictures' => json_decode($this->pictures),
            'replies' => BBSReply::where('topic_id', '=', $this->id)->count(),
            'lastReply' => $this->lastReply == null ? [
                'time' => $this->created_at->format('Y-m-d H:i:s')
            ] : [
                'time' => $this->lastReply->created_at->format('Y-m-d H:i:s'),
                'user' => strval($this->lastReply->user->id),
                'nickname' => strval($this->lastReply->user->nickname)
            ],
            'time' => $this->created_at->format('Y-m-d H:i:s'),
            'viewCount' => $this->view_count,
            'likeCount' => count($this->likes)
        ];
    }

    public function getUserBrief() {
        return [
            '_id' => strval($this->user->id),
            'nickname' => $this->user->nickname,
            'avatar' => $this->user->avatar
        ];
    }
}
