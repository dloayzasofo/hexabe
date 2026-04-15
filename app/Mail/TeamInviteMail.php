<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\TeamInvitation;

class TeamInviteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $teamInvitation;

    public function __construct(TeamInvitation $teamInvitation)
    {
        $this->teamInvitation = $teamInvitation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Invitación al equipo ' . $this->teamInvitation->team->name)->view('emails.teaminvite');
    }
}
