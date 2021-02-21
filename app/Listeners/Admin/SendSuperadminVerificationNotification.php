<?php

namespace App\Listeners\Admin;

use App\Events\Admin\SuperadminCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSuperadminVerificationNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param SuperadminCreated $event
     * @return void
     */
    public function handle(SuperadminCreated $event)
    {
        $event->superadmin->sendEmailVerificationNotification();
        ray('sent');
    }
}
