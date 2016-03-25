<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-20
 * Time: 下午5:06
 */

namespace NEUQer\Http\Controllers\REST;


use NEUQer\BBSBoard;
use NEUQer\BBSLike;
use NEUQer\BBSReply;
use NEUQer\BBSTopic;
use NEUQer\Http\Controllers\Controller;
use Auth;
use Request;
use Response;
use DB;

class BBSController extends Controller
{
    public function getTags() {
        $tags = BBSBoard::all();
        return Response::json($tags);
    }

    public function getTopics() {
        $per = Request::query('per', 20);
        $page = Request::query('page', 1);
        $topics = BBSTopic::getLatest($per, $page);
        return Response::json($topics);
    }

    public function getTopicsByTag() {
        $per = Request::query('per', 20);
        $page = Request::query('page', 1);
        $topics = BBSTopic::getByTag(Request::query('tag'), $per, $page);
        return Response::json($topics);
    }

    public function getTopic() {
        $topic = BBSTopic::whereId(Request::query('id'))->firstOrFail();
        $result = $topic->toArray();
        $result['liked'] = $topic->isLikedByUser(Auth::guard('api')->user());
        return Response::json($result);
    }

    public function getReplies() {
        $per = Request::query('per', 20);
        $page = Request::query('page', 1);
        $replies = BBSReply::getByTopicId(Request::query('id'), $per, $page);
        $result = [];
        foreach ($replies as $reply) {
            $tmp = $reply->toArray();
            $tmp['liked'] = $reply->isLikedByUser(Auth::guard('api')->user());
            $result[] = $tmp;
        }
        return Response::json($result);
    }

    public function getReply() {
        $reply = BBSReply::whereId(Request::query('id'))->firstOrFail();
        $result = $reply->toArray();
        $result['liked'] = $reply->isLikedByUser(Auth::guard('api')->user());
        return Response::json($result);
    }

    public function getComments() {
        return Response::json(BBSReply::getCommentsByReplyId(Request::query('id'), Request::query('per', 20), Request::query('page', 1)));
    }

    public function likeTopic() {
        $topic = BBSTopic::whereId(Request::input('topicId'))->firstOrFail();
        $like = new BBSLike();
        $like->likeable()->associate($topic);
        $like->user()->associate(Auth::guard('api')->user());
        $like->saveOrFail();
    }

    public function likeReply() {
        $reply = BBSReply::whereId(Request::input('replyId'))->firstOrFail();
        $like = new BBSLike();
        $like->likeable()->associate($reply);
        $like->user()->associate(Auth::guard('api')->user());
        $like->saveOrFail();
    }

    public function postTopic() {
        $topic = new BBSTopic();
        $topic->user()->associate(Auth::guard('api')->user());
        $tag = Request::input('tag');
        $board = BBSBoard::whereName($tag)->firstOrFail();
        $topic->board()->associate($board);
        $topic->title = Request::input('title');
        $topic->content = Request::input('content');
        $topic->pictures = Request::input('pictures');
        $topic->floors = 1;
        $topic->saveOrFail();
    }

    public function postReply() {
        DB::transaction(function () {
            /** @var BBSTopic $topic */
            $topic = BBSTopic::whereId(Request::input('topic'))->lockForUpdate()->firstOrFail();
            $reply = new BBSReply();
            $reply->topic()->associate($topic);
            $reply->user()->associate(Auth::guard('api')->user());
            $reply->content = Request::input('content');
            $reply->pictures = Request::input('pictures', []);
            $reply->floor = $topic->floors +1;
            $reply->saveOrFail();
            $topic->floors = $topic->floors + 1;
            $topic->lastReply()->associate($reply);
            $topic->saveOrFail();
        });
    }
}