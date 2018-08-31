<?php

namespace App\Mail\Backend\Notice;

use App\Models\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class NewNotice.
 */
class NewNotice extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Request
     * @var User
     */
    public $request, $user;

    /**
     * SendContact constructor.
     *
     * @param Request $request
     * @param User $user
     */
    public function __construct(Request $request, User $user)
    {
        $this->request = $request;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->user == null) return $this;
        return $this->to($this->user->email, $this->user->name)
            ->view('backend.mail.notice')
            ->text('backend.mail.notice-text')
            ->subject(__('strings.emails.reply.subject', ['app_name' => app_name()]))
            ->from(config('mail.from.address'), config('mail.from.name'));
    }
}
