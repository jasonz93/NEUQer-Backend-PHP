<?php

namespace NEUQer\Console\Commands;

use Illuminate\Console\Command;
use NEUQer\Role;

class InitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize some base things for the project';

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
        $this->info('Initialization start!');
        $adminRole = Role::whereName('admin')->first();
        if ($adminRole == null) {
            $adminRole = new Role();
            $adminRole->name = 'admin';
            $adminRole->display_name = 'Administrators';
            $adminRole->description = 'Users that can manage the whole site.';
            $adminRole->saveOrFail();
            $this->info('Created admin role.');
        } else {
            $this->info('Admin role has already been created.');
        }
        $this->info('Initialization done!');
    }
}
