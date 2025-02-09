<?php
namespace App\Mail;

use App\Models\Employe;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewEmployeeCredentials extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;
    public $password;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Employee  $employee
     * @param  string  $password
     * @return void
     */
    public function __construct(Employe $employee, $password)
    {
        $this->employee = $employee;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Vos identifiants de connexion')
            ->view('emails.new-employee-credentials');
    }
}
