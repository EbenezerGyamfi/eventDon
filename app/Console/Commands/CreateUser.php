<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user {role=admin: The role of the user (admin/client)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user based on their role.';

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
     * @return int
     */
    public function handle()
    {
        $name = $this->ask('What is the name of the user?');
        $email = $this->ask('What is the email of the user?');
        $password = $this->secret('What is the password of the user?');

        $role = $this->argument('role');

        while (in_array($role, ['admin', 'client']) === false) {
            $role = $this->anticipate(
                "Invalid role: {$role} selected! What is the role of the user? (admin/client)",
                ['admin', 'client']
            );
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $role,
            'email_verified_at' => Carbon::now(),
            'remember_token' => Str::random(10),
        ]);

        $this->info('The user has been created successfully!');
        $this->newLine();

        return 0;
    }
}
