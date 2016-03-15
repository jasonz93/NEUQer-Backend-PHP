<?php

namespace NEUQer\Console\Commands;

use Illuminate\Console\Command;
use NEUQer\SDK\Easemob\EasemobClient;

class EasemobClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'easemob:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear easemob users';

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
        $this->info('Trying to clear easemob users...');
        $token = $this->client->getAccessToken()['accessToken'];
        do {
            $result = $this->client->batchDeleteUsers([
                'token' => 'Bearer '.$token,
                'limit' => 200
            ]);
            $count = count($result['entities']);
            $this->info("Deleted $count users.");
        } while ($count !== 0);
        $this->info('Easemob users has been cleared!');
    }
}
