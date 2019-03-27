<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class createAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin {--email=} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin';

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
        User::insert(
            ['name' => "admin",
            'profile_img' => "default",
            'role_id' => "1",
            'role_type' => "admin",
            'email' => $this->option('email'),
            'password'=>$this->option('password')]
        );
    }
}
