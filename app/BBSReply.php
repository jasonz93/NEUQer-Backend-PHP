<?php

namespace NEUQer;

use Illuminate\Database\Eloquent\Model;

class BBSReply extends Model
{
    protected $table = 'bbs_replies';

    public function topic() {
        return $this->belongsTo('NEUQer\BBSTopic');
    }

    public function user() {
        return $this->belongsTo('NEUQer\User');
    }

    public function reply() {
        return $this->belongsTo('NEUQer\BBSReply');
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
            'topic' => strval($this->topic->id),
            'user' => strval($this->user->id),
            'content' => $this->content,
            'pictures' => json_decode($this->pictures),
            'commentCount' => BBSReply::where('reply_id', '=', $this->id)->count(),
            'floor' => $this->floor,
            'time' => strtotime($this->created_at) * 1000
        ];
    }
}
