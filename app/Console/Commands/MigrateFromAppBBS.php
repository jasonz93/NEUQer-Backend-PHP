<?php

namespace NEUQer\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use DB;
use MongoDB\Client;
use MongoDB\Model\BSONArray;
use NEUQer\BBSBoard;
use NEUQer\BBSLike;
use NEUQer\BBSReply;
use NEUQer\BBSTopic;
use NEUQer\User;
use Redis;

class MigrateFromAppBBS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:app:bbs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate home datas from App';

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
        $this->info('Start to migrate bbs datas...');
        $config = config('neuqer')['bbs'];
        $mongo = new Client($config['mongo']);
//        $mongo = new \MongoClient($config['mongo']);
        $db = $mongo->selectDatabase($config['dbname']);
        $topicCollection = $db->selectCollection('topics');
        $replyCollection = $db->selectCollection('replies');
        $commentCollection = $db->selectCollection('comments');
        $tagCollection = $db->selectCollection('tags');
        $accuseCollection = $db->selectCollection('accuses');
        DB::transaction(function () use ($tagCollection, $topicCollection, $replyCollection, $commentCollection, $accuseCollection) {

            $allTags = $tagCollection->find();
            $boards = [];
            foreach ($allTags as $tag) {
                $board = new BBSBoard();
                $board->name = $tag['name'];
                $board->description = $tag['description'];
                $board->picture = $tag['picture'];
                $board->saveOrFail();
                $boards[$tag['name']] = $board;
            }
            $allTopics = $topicCollection->find();
            $topics = [];
            foreach ($allTopics as $oldTopic) {
                $this->info('Migrating topic '.$oldTopic['title']);
                $user = User::where('oldid', '=', $oldTopic['user'])->firstOrFail();
                $topic = new BBSTopic();
                $topic->user()->associate($user);
                $board = $boards[$oldTopic['tags']->bsonSerialize()[0]];
                $topic->board()->associate($board);
                $topic->title = $oldTopic['title'];
                $topic->content = $oldTopic['content'];
                if (isset($oldTopic['pictures'])) {
                    $topic->pictures = $oldTopic['pictures']->bsonSerialize();
                } else {
                    $topic->pictures = [];
                }
                $topic->created_at = Carbon::createFromTimestamp($oldTopic['time']->toDateTime()->getTimestamp());
                $topic->view_count = $oldTopic['viewCount'];
                $topic->oldid = $oldTopic['_id'];
                $topic->saveOrFail();
                $topics[strval($topic->oldid)] = $topic;
                $likes = Redis::command('hgetall', ["bbs:like:topic:{$topic->oldid}"]);
                foreach ($likes as $userid => $time) {
                    $time = intval($time) / 1000;
                    $user = User::whereOldid($userid)->firstOrFail();
                    $like = new BBSLike();
                    $like->likeable()->associate($topic);
                    $like->user()->associate($user);
                    $like->created_at = Carbon::createFromTimestamp($time);
                    $like->saveOrFail();
                }
            }
            $allReplies = $replyCollection->find();
            $replies = [];
            foreach ($allReplies as $oldReply) {
                $topic = $topics[strval($oldReply['topic'])];
                $this->info('Migrating floor '.$oldReply['floor'].' for topic '.$topic->title);
                $replyUser = User::whereOldid($oldReply['user'])->firstOrFail();
                $reply = new BBSReply();
                $reply->user()->associate($replyUser);
                $reply->topic()->associate($topic);
                $reply->content = $oldReply['content'];
                if (isset($oldReply['pictures'])) {
                    $reply->pictures = $oldReply['pictures']->bsonSerialize();
                } else {
                    $reply->pictures = [];
                }
                $reply->floor = $oldReply['floor'];
                $reply->created_at = Carbon::createFromTimestamp($oldReply['time']->toDateTime()->getTimestamp());
                $reply->oldid = $oldReply['_id'];
                $reply->saveOrFail();
                $replies[strval($reply->oldid)] = $reply;
                $likes = Redis::command('hgetall', ["bbs:like:reply:{$reply->oldid}"]);
                foreach ($likes as $userid => $time) {
                    $time = intval($time) / 1000;
                    $user = User::whereOldid($userid)->firstOrFail();
                    $like = new BBSLike();
                    $like->likeable()->associate($reply);
                    $like->user()->associate($user);
                    $like->created_at = Carbon::createFromTimestamp($time);
                    $like->saveOrFail();
                }
            }
            foreach ($topics as $topic) {
                $lastReply = BBSReply::whereHas('topic', function ($query) use ($topic) {
                    $query->where('id', '=', $topic->id);
                })->orderBy('created_at', 'desc')->first();
                if ($lastReply != null) {
                    $topic->lastReply()->associate($lastReply);
                    $topic->floors = $lastReply->floor;
                } else {
                    $topic->floors = 1;
                }
                $topic->saveOrFail();
            }
            $allComments = $commentCollection->find();
            foreach ($allComments as $oldComment) {
                $reply = $replies[strval($oldComment['reply'])];
                $commentUser = User::whereOldid($oldComment['user'])->firstOrFail();
                $comment = new BBSReply();
                $comment->user()->associate($commentUser);
                $comment->topic()->associate($reply->topic);
                $comment->reply()->associate($reply);
                $comment->content = $oldComment['content'];
                $comment->created_at = Carbon::createFromTimestamp($oldComment['time']->toDateTime()->getTimestamp());
                $comment->saveOrFail();
            }

//            foreach ($tags as $tag) {
//                $board = new BBSBoard();
//                $board->name = $tag['name'];
//                $board->description = $tag['description'];
//                $board->picture = $tag['picture'];
//                $board->saveOrFail();
//                $topics = $topicCollection->find([
//                    'tags' => $board->name
//                ]);
//                foreach ($topics as $oldTopic) {
//                    $user = User::where('oldid', '=', $oldTopic['user'])->firstOrFail();
//                    $topic = new BBSTopic();
//                    $topic->user()->associate($user);
//                    $topic->board()->associate($board);
//                    $topic->title = $oldTopic['title'];
//                    $topic->content = $oldTopic['content'];
//                    if (isset($oldTopic['pictures'])) {
//                        $topic->pictures = $oldTopic['pictures']->bsonSerialize();
//
//                    } else {
//                        $topic->pictures = [];
//                    }
//                    $topic->created_at = Carbon::createFromTimestamp($oldTopic['time']->toDateTime()->getTimestamp());
//                    $topic->view_count = $oldTopic['viewCount'];
//                    $topic->oldid = $oldTopic['_id'];
//                    $topic->saveOrFail();
//                    $likes = Redis::command('hgetall', ["bbs:like:topic:{$topic->oldid}"]);
//                    foreach ($likes as $userid => $time) {
//                        $time = intval($time) / 1000;
//                        $user = User::whereOldid($userid)->firstOrFail();
//                        $like = new BBSLike();
//                        $like->likeable()->associate($topic);
//                        $like->user()->associate($user);
//                        $like->created_at = Carbon::createFromTimestamp($time);
//                        $like->saveOrFail();
//                    }
//                    $replies = $replyCollection->find([
//                        'topic' => $oldTopic['_id']
//                    ]);
//                    $floor = 0;
//                    foreach ($replies as $oldReply) {
//                        $this->info('Migrating floor '.$oldReply['floor'].' for topic '.$topic->title);
//                        $replyUser = User::whereOldid($oldReply['user'])->firstOrFail();
//                        $reply = new BBSReply();
//                        $reply->user()->associate($replyUser);
//                        $reply->topic()->associate($topic);
//                        $reply->content = $oldReply['content'];
//                        if (isset($oldReply['pictures'])) {
//                            $reply->pictures = $oldReply['pictures']->bsonSerialize();
//                        } else {
//                            $reply->pictures = [];
//                        }
//                        $reply->floor = $oldReply['floor'];
//                        $floor = $reply->floor;
//                        $reply->created_at = Carbon::createFromTimestamp($oldReply['time']->toDateTime()->getTimestamp());
//                        $reply->oldid = $oldReply['_id'];
//                        $reply->saveOrFail();
//                        $likes = Redis::command('hgetall', ["bbs:like:reply:{$reply->oldid}"]);
//                        foreach ($likes as $userid => $time) {
//                            $time = intval($time) / 1000;
//                            $user = User::whereOldid($userid)->firstOrFail();
//                            $like = new BBSLike();
//                            $like->likeable()->associate($reply);
//                            $like->user()->associate($user);
//                            $like->created_at = Carbon::createFromTimestamp($time);
//                            $like->saveOrFail();
//                        }
//                        $comments = $commentCollection->find([
//                            'reply' => $oldReply['_id']
//                        ]);
//                        foreach ($comments as $oldComment) {
//                            $commentUser = User::whereOldid($oldComment['user'])->firstOrFail();
//                            $comment = new BBSReply();
//                            $comment->user()->associate($commentUser);
//                            $comment->topic()->associate($topic);
//                            $comment->reply()->associate($reply);
//                            $comment->content = $oldComment['content'];
//                            $comment->created_at = Carbon::createFromTimestamp($oldComment['time']->toDateTime()->getTimestamp());
//                            $comment->saveOrFail();
//                        }
//                    }
//                    $topic->floors = $floor + 1;
//                    $lastReply = BBSReply::whereHas('topic', function ($query) use ($topic) {
//                        $query->where('id', '=', $topic->id);
//                    })->first();
//                    if ($lastReply != null) {
//                        $topic->lastReply()->associate($lastReply);
//                    }
//                    $topic->saveOrFail();
//                }
//            }
        });
    }
}
