<?php

namespace NEUQer\Console\Commands;

use Illuminate\Console\Command;
use MongoDB\Client;
use MongoDB\Driver\Cursor;
use NEUQer\User;
use DB;

class MigrateFromAppAuth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:app:auth';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate data from app(Auth)';

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
        $config = config('neuqer')['auth'];
//        $mongo = new \MongoClient($config['mongo']);
        $mongo = new Client($config['mongo']);
        $db = $mongo->selectDatabase($config['dbname']);
        $userCollection = $db->selectCollection('users');
        $users = $userCollection->find([
            'mobile' => [
                '$ne' => null
            ]
        ]);
        DB::transaction(function () use ($users) {
            foreach ($users as $oldUser) {
                $oldId = $oldUser['_id'];
                $user = new User();
//                $user->setCreatedAt($oldId->getTimestamp());
                $user->nickname = $oldUser['nickname'];
                $user->mobile = $oldUser['mobile'];
                $user->password = $oldUser['password'];
                if (isset($oldUser['sign'])) {
                    $user->sign = $oldUser['sign'];
                }
                if (isset($oldUser['avatar'])) {
                    $user->avatar = $oldUser['avatar'];
                }
                if (isset($oldUser['sex'])) {
                    $user->sex = $oldUser['sex'];
                }
                $user->oldid = strval($oldId);
                try {
                    $user->save();
                } catch (\Exception $e) {
                    if ($e->getCode() === '23000') {
                        $this->info('Duplicate mobile, skip it is just fine.');
                    } else {
                        throw $e;
                    }
                }
                $this->info("Migrated user {$oldUser['nickname']} with id {$oldUser['_id']}");
            }
        });
    }
}
