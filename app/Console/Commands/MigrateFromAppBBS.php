<?php

namespace NEUQer\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use DB;
use NEUQer\BBSBoard;
use NEUQer\BBSReply;
use NEUQer\BBSTopic;
use NEUQer\User;

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
        $mongo = new \MongoClient($config['mongo']);
        $db = $mongo->selectDB($config['dbname']);
        $topicCollection = $db->selectCollection('topics');
        $replyCollection = $db->selectCollection('replies');
        $commentCollection = $db->selectCollection('comments');
        $tagCollection = $db->selectCollection('tags');
        $accuseCollection = $db->selectCollection('accuses');
        $tags = $tagCollection->find();
        DB::transaction(function () use ($tags, $topicCollection, $replyCollection, $commentCollection, $accuseCollection) {
            foreach ($tags as $tag) {
                $board = new BBSBoard();
                $board->name = $tag['name'];
                $board->description = $tag['description'];
                $board->picture = $tag['picture'];
                $board->saveOrFail();
                $topics = $topicCollection->find([
                    'tags' => $board->name
                ]);
                foreach ($topics as $oldTopic) {
                    $this->info('Migrating topic '.$oldTopic['title']);
                    $user = User::where('oldid', '=', $oldTopic['user'])->firstOrFail();
                    $topic = new BBSTopic();
                    $topic->user()->associate($user);
                    $topic->board()->associate($board);
                    $topic->title = $oldTopic['title'];
                    $topic->content = $oldTopic['content'];
                    if (isset($oldTopic['pictures'])) {
                        $topic->setPictures($oldTopic['pictures']);
                    } else {
                        $topic->setPictures([]);
                    }
                    $topic->created_at = Carbon::createFromTimestamp($oldTopic['time']->toDateTime()->getTimestamp());
                    $topic->view_count = $oldTopic['viewCount'];
                    $topic->oldid = $oldTopic['_id'];
                    $topic->saveOrFail();
                    $replies = $replyCollection->find([
                        'topic' => $oldTopic['_id']
                    ]);
                    foreach ($replies as $oldReply) {
                        $this->info('Migrating floor '.$oldReply['floor'].' for topic '.$topic->title);
                        $replyUser = User::whereOldid($oldReply['user'])->firstOrFail();
                        $reply = new BBSReply();
                        $reply->user()->associate($replyUser);
                        $reply->topic()->associate($topic);
                        $reply->content = $oldReply['content'];
                        if (isset($oldReply['pictures'])) {
                            $reply->setPictures($oldReply['pictures']);
                        } else {
                            $reply->setPictures([]);
                        }
                        $reply->floor = $oldReply['floor'];
                        $reply->created_at = Carbon::createFromTimestamp($oldReply['time']->toDateTime()->getTimestamp());
                        $reply->saveOrFail();
                        $comments = $commentCollection->find([
                            'reply' => $oldReply['_id']
                        ]);
                        foreach ($comments as $oldComment) {
                            $commentUser = User::whereOldid($oldComment['user'])->firstOrFail();
                            $comment = new BBSReply();
                            $comment->user()->associate($commentUser);
                            $comment->topic()->associate($topic);
                            $comment->reply()->associate($reply);
                            $comment->content = $oldComment['content'];
                            $comment->created_at = Carbon::createFromTimestamp($oldComment['time']->toDateTime()->getTimestamp());
                            $comment->saveOrFail();
                        }
                    }
                    $lastReply = BBSReply::whereHas('topic', function ($query) use ($topic) {
                        $query->where('id', '=', $topic->id);
                    })->first();
                    if ($lastReply != null) {
                        $topic->lastReply()->associate($lastReply);
                        $topic->saveOrFail();
                    }
                }
            }
        });
    }
}
