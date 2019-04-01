<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Hash;
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
        User::create(
            ['name' => "admin",
            'profile_img' => "default",
            'role_id' => "1",
            'role_type' => "admin",
            'email' => $this->option('email'),
            'password'=>Hash::make($this->option('password'))]
        )->assignRole('admin')->givePermissionTo(['create gym manager','create city manager',
        'create gym','create city',
        'create coach','create package','create session',

        'edit gym manager','edit city manager',
        'edit gym','edit city',
        'edit coach','edit package','edit session',

        'delete gym manager','delete city manager',
        'delete gym','delete city',
        'delete coach','delete package','delete session',

        'retrieve gym manager','retrieve city manager',
        'retrieve gym','retrieve city',
        'retrieve coach','retrieve package','retrieve session',

        'retrieve attendance','buy package','assign coach',
        'ban gym manager','unban gym manager']);
    }
}
