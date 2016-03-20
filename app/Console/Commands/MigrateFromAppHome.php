<?php

namespace NEUQer\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use DB;
use MongoDB\Client;
use MongoDB\Driver\Server;
use NEUQer\HomeMessage;

class MigrateFromAppHome extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:app:home';

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
        $this->info('Start to migrate home datas...');
        $config = config('neuqer')['home'];
        $mongo = new Client($config['mongo']);
        $db = $mongo->selectDatabase($config['dbname']);
        $itemCollection = $db->selectCollection('items');
        $items = $itemCollection->find();
        DB::transaction(function () use ($items) {
            foreach ($items as $item) {
                $home = new HomeMessage();
                if (isset($item['banner']))
                    $home->banner = $item['banner'];
                if (isset($item['icon']))
                    $home->icon = $item['icon'];
                $home->title = $item['title'];
                if (isset($item['subtitle']))
                    $home->subtitle = $item['subtitle'];
                $home->type = $item['click']['type'];
                switch ($item['click']['type']) {
                    case 'view':
                        $home->param = $item['click']['url'];
                        break;
                    case 'bbs':
                        $home->param = $item['click']['attr']['topicId'];
                        break;
                }
                $home->is_banner = $item['isBanner'];
                $home->position = $item['position'];
                $home->show = $item['show'];
                if (isset($item['createTime'])) {
                    $home->created_at = $item['createTime']->toDateTime()->getTimestamp();
                }
                $home->saveOrFail();
            }
        });
        $this->info('Home datas migration complete!');
    }
}
