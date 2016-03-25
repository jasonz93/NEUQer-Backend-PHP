<?php

namespace NEUQer;

use Illuminate\Database\Eloquent\Model;

class BBSReply extends Model
{
    protected $table = 'bbs_replies';
    protected $casts = [
        'pictures' => 'array'
    ];

    public function topic() {
        return $this->belongsTo('NEUQer\BBSTopic');
    }

    public function user() {
        return $this->belongsTo('NEUQer\User');
    }

    public function reply() {
        return $this->belongsTo('NEUQer\BBSReply');
    }

    public function likes() {
        return $this->morphMany('NEUQer\BBSLike', 'likeable');
    }

    public function comments() {
        return $this->hasMany('NEUQer\BBSReply', 'reply_id', 'id');
    }

    public function removed() {
        return $this->morphOne('NEUQer\BBSOperation', 'entity');
    }

    public function isLikedByUser(User $user) {
        return $this->likes()->getQuery()->where('user_id', '=', $user->id)->count() > 0;
    }

    public static function getByTopicId($topicId, $per, $page) {
        return self::whereTopicId($topicId)
            ->doesntHave('reply')
            ->limit($per)
            ->offset($per * ($page - 1))
            ->get();
    }

    public static function getCommentsByReplyId($replyId, $per, $page) {
        return self::whereReplyId($replyId)
            ->limit($per)
            ->offset($per * ($page - 1))
            ->get();
    }

    public function toArray()
    {
        $arr = [
            'id' => strval($this->id),
            '_id' => strval($this->id),
            'topic' => strval($this->topic->id),
            'user' => strval($this->user->id),
            'userBrief' => $this->getUserBrief(),
            'content' => $this->content,
            'pictures' => $this->pictures,
            'likeCount' => count($this->likes),
            'comments' => $this->comments->slice(0, 3),
            'commentCount' => BBSReply::where('reply_id', '=', $this->id)->count(),
            'floor' => $this->floor,
            'time' => $this->created_at->format('Y-m-d H:i:s')
        ];
        $arr['hasMoreComments'] = $arr['commentCount'] > 3;
        return $arr;
    }
    public function getUserBrief() {
        return [
            '_id' => strval($this->user->id),
            'nickname' => $this->user->nickname,
            'avatar' => $this->user->avatar
        ];
    }
}
