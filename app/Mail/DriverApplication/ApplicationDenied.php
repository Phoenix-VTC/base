<?php

namespace App\Mail\DriverApplication;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationDenied extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    /**
     * The application instance.
     *
     * @var Application
     */
    public Application $application;

    /**
     * Create a new message instance.
     *
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Build the message.
     *
     * @return ApplicationDenied
     */
    public function build(): ApplicationDenied
    {
        return $this->markdown('emails.driver-application.application-denied');
    }
}
