<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailUpdateForm extends Mailable
{
    use Queueable, SerializesModels;

    public $update;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($update)
    {
        //
        $this->update = $update;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->from('it@rapidplast.id')
                  ->view('mails.updateform')
                  ->subject('IPSystem Updated Request Notification')
                  //->text('mails.demo_plain')
                  ->with(
                    [
                          'testVarOne' => 'IPSystem Administrator',
                          'testVarTwo' => '2',
                    ]);
    }
}
