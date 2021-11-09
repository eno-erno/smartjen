<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class Email extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailData)
    {
        $this->emailData = $emailData;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->from('hernowo.dumet@gmail.id');
         return $this->subject('Account Login')->view('email')->with([
            'data' =>  $this->emailData,
        ]);
    }
}