<?php

namespace App\Listeners\Visit\Created;

use App\Events\Visit\Created;
use App\Mails\VisitCreatedCustomerNotify;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendCustomerNotification implements ShouldQueue
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
     * @param  Created  $event
     * @return void
     */
    public function handle(Created $event)
    {
        Mail::to($event->visit->client->email)
            ->send(new VisitCreatedCustomerNotify($event->visit));
    }
}
