<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Validator;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {--superadmin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $data['username'] = $this->ask('Please enter the username');
        $data['email'] = $this->ask('Please enter the email address');
        $data['password'] = $this->secret('Please enter the password');
        $data['passwordConfirmation'] = $this->secret('Please confirm the password');

        $validator = Validator::make($data, [
            'username' => ['required', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'same:passwordConfirmation'],
        ]);

        if ($validator->fails()) {
            $this->info('Validation failed:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            exit;
        }

        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if ($this->option('superadmin')) {
            $user->assignRole('super admin');
        }

        $this->info("User $user->username created successfully");
    }
}
