<?php

namespace NEUQer\Console\Commands;

use Illuminate\Console\Command;
use NEUQer\SDK\Easemob\EasemobClient;
use NEUQer\User;

class EasemobBuildCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'easemob:build';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build easemob users from database';

    /**
     * @var EasemobClient
     */
    private $client;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(EasemobClient $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Start to build easemob users...');
        $users = User::whereNotNull('mobile')->get();
        $easemobUsers = [];
        foreach ($users as $user) {
            if ($user->mobile != null) {
                $easemobUsers[] = [
                    'username' => strval($user->id),
                    'password' => $user->password,
                    'nickname' => $user->nickname
                ];
            }
        }
        $iterator = new \ArrayIterator($easemobUsers);
        $tmp = [];
        $token = $this->client->getAccessToken()['accessToken'];
        for ($i = 0; $i < count($easemobUsers); $i ++) {
            if ($i === count($easemobUsers) - 1 || $i % 30 === 1) {
                $this->client->batchAddUsers([
                    'token' => 'Bearer '.$token,
                    'users' => json_encode($tmp)
                ]);
                $this->info('Added '.count($tmp).' easemob users.');
                $tmp = [];
            }
            $tmp[] = $easemobUsers[$i];
        }
    }
}
