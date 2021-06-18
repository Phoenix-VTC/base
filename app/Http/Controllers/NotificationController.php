<?php

namespace App\Http\Controllers;

use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function markAsRead(DatabaseNotification $notification)
    {
        $notification->markAsRead();

        if (isset($notification->data['link'])) {
            return redirect($notification->data['link']);
        }

        return back();
    }
}
