<?php

namespace App\Mails;

use App\Models\Visit;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VisitCreatedEmployeeNotify extends Mailable
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
        return $this->subject('Новый визит в ' . config('app.name'))
            ->markdown('mails.visit-created-employee-notify')
            ->with([
                'visit' => $this->visit,
            ]);
    }
}
