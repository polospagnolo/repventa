<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ImportFinish extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to('joseantoniorojas@spagnolo.com.es','Jose Antonio')
            //->cc(['m'])
            ->attach(public_path('txt/Traspaso.txt'))
            ->markdown('emails.importfinish');
    }

    public function handle()
    {

    }
}
