<?php

namespace App\Mail\Frontend\Post;

use App\Models\Auth\User;
use App\Models\Forum\Post;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class SendReply.
 */
class SendReply extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Request
     */
    public $request;

    /**
     * SendContact constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $targetPost = Post::findOrFail($this->request->parent_id);
        $targetUser = User::findOrFail($targetPost->user_id);
        if ($targetUser == null) return $this;
        return $this->to($targetUser->email, $targetUser->name)
            ->view('frontend.mail.reply')
            ->text('frontend.mail.reply-text')
            ->subject(__('strings.emails.reply.subject', ['app_name' => app_name()]))
            ->from(config('mail.from.address'), config('mail.from.name'));
    }
}
