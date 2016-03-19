<?php

namespace NEUQer;

use Illuminate\Database\Eloquent\Model;

class BBSTopic extends Model
{
    protected $table = 'bbs_topics';

    public function user() {
        return $this->belongsTo('NEUQer\User');
    }

    public function board() {
        return $this->belongsTo('NEUQer\BBSBoard');
    }

    public function lastReplyUser() {
        return $this->belongsTo('NEUQer\User', 'last_reply_user_id', 'id');
    }

    public function setPictures(array $pictures) {
        $this->pictures = json_encode($pictures);
        return $this;
    }

    public function toArray()
    {
        return [
            'id' => strval($this->id),
            '_id' => strval($this->id),
            'user' => strval($this->user->id),
            'tags' => [
                $this->board->name
            ],
            'title' => $this->title,
            'content' => $this->content,
            'pictures' => json_decode($this->pictures),
            'replies' => BBSReply::where('topic_id', '=', $this->id)->count(),
            'lastReply' => [
                'time' => strtotime($this->last_reply_time) * 1000,
                'user' => strval($this->lastReplyUser->id),
                'nickname' => $this->lastReplyUser->nickname
            ],
            'time' => strtotime($this->created_at) * 1000,
            'viewCount' => $this->view_count
        ];
    }
}
