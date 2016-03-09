<?php

namespace NEUQer\Console\Commands;

use Illuminate\Console\Command;
use NEUQer\Role;
use NEUQer\User;

class InitAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize admin account';

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
        $adminRole = Role::whereName('admin')->first();
        if ($adminRole == null) {
            $this->error('Admin role has not been created, please run init first.');
            return;
        }
        MODE:
        $mode = $this->askWithCompletion('Would you like to create a new admin user or find an exist one? (create/find)', ['create', 'find'], 'find');
        if ($mode === 'create') {
            $this->info('Now creating a new admin user.');
            $email = $this->ask('Admin account email: ');
        } else if ($mode === 'find') {
            $this->info('Now finding an exist user.');
            FIND_EMAIL:
            $email = $this->ask('Admin account email: ');
            /** @var User $user */
            $user = User::whereEmail($email)->first();
            if ($user == null) {
                $this->error('Cannot find a user with specified email.');
            } else {
                if ($user->hasRole('admin')) {
                    $this->info('This user is already an admin.');
                } else {
                    $user->attachRole($adminRole);
                    $this->info('Set this user as admin successfully!');
                }
            }
        } else {
            goto MODE;
        }
        $continue = $this->askWithCompletion('Would you set another admin user? (yes/no)', ['yes', 'no'], 'yes');
        if ($continue === 'yes') {
            goto MODE;
        }
    }
}
