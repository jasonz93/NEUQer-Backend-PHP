<?php

namespace NEUQer;

use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Carbon;

class BBSTopic extends Model
{
    protected $table = 'bbs_topics';
    protected $casts = [
        'pictures' => 'array'
    ];

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

    public static function getLatest($per, $page) {
        return self::doesntHave('removed')
            ->selectRaw('bbs_topics.*,1 as list, (case when bbs_replies.created_at > bbs_topics.created_at then bbs_replies.created_at else bbs_topics.created_at end) as order_field')
            ->leftJoin('bbs_replies', 'bbs_topics.last_reply_id', '=', 'bbs_replies.id')
            ->orderBy('order_field', 'desc')
            ->limit($per)
            ->offset($per * ($page - 1))
            ->get();
    }

    public static function getByTag($tag, $per, $page) {
        return self::doesntHave('removed')
            ->selectRaw('bbs_topics.*,1 as `list`, (case when bbs_replies.created_at > bbs_topics.created_at then bbs_replies.created_at else bbs_topics.created_at end) as order_field')
            ->leftJoin('bbs_replies', 'bbs_topics.last_reply_id', '=', 'bbs_replies.id')
            ->whereHas('board', function ($query) use ($tag) {
                $query->where('name', '=', $tag);
            })
            ->orderBy('order_field', 'desc')
            ->limit($per)
            ->offset($per * ($page - 1))
            ->get();
    }

    public function isLikedByUser(User $user) {
        return $this->likes()->getQuery()->where('user_id', '=', $user->id)->count() > 0;
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
            'content' => isset($this->list) ? mb_substr($this->content, 0, 100) : $this->content,
            'pictures' => isset($this->list) ? array_slice($this->pictures, 0, 3) : $this->pictures,
            'replies' => BBSReply::where('topic_id', '=', $this->id)->doesntHave('reply')->count(),
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
