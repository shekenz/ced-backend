<?php

namespace App\Mail;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class SystemError extends Mailable
{
    use Queueable, SerializesModels;

	public $customMessage;
	public $e;
	public $debugData;
	public $now;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message, Exception $e, $debugData)
    {
        $this->customMessage = $message;
		$this->e = $e;
		$this->debugData = $debugData;
		$this->now = Carbon::now()->toDayDateTimeString(); 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.system-error')->subject('Critical Error Notification');
    }
}
