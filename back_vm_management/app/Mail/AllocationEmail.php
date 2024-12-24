<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AllocationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $allocation;

    public function __construct($allocation)
    {
        $this->allocation = $allocation;
    }

    public function build()
    {
        return $this->subject('Allocation Details')
                    ->view('allocation')
                    ->with(['allocation' => $this->allocation]);
    }
}

