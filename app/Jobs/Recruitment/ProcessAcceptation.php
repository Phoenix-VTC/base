<?php

namespace App\Jobs\Recruitment;

use App\Models\Application;
use App\Models\User;
use App\Notifications\DriverApplication\WelcomeNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;

class ProcessAcceptation implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * The application instance.
     *
     * @var Application
     */
    public Application $application;

    /**
     * Create a new job instance.
     *
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        if (User::where('username', '=', $this->application->username)->exists()) {
            $this->application->username .= "-" . Uuid::uuid4()->getHex();
        }

        $user = User::create([
            'email' => $this->application->email,
            'username' => $this->application->username,
            'password' => Hash::make(Str::random()),
            'welcome_valid_until' => now()->addDays(3),
            'welcome_token' => Str::random(64),
        ]);
        $user->assignRole('driver');

        $user->notify(new WelcomeNotification($user));
    }
}
