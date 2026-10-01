<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailReject extends Mailable
{
    use Queueable, SerializesModels;

    public $reject;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reject)
    {
        //
        $this->reject = $reject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->from('it@rapidplast.id')
                  ->view('mails.reject')
                  ->subject('IPSystem Reject Request Notification')
                  //->text('mails.demo_plain')
                  ->with(
                    [
                          'testVarOne' => '1',
                          'testVarTwo' => '2',
                    ]);
    }
}
