<?php

namespace App\Mails;

use App\Models\Visit;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VisitCreatedCustomerNotify extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Visit $visit)
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Визит в ' . config('app.name') . ' создан')
            ->markdown('mails.visit-created-customer-notify')
            ->with([
                'visit' => $this->visit,
            ]);
    }
}
