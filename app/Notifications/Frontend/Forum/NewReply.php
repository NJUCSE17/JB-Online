<?php

namespace App\Notifications\Frontend\Forum;

use App\Models\Auth\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Class NewReply.
 */
class NewReply extends Notification
{
    use Queueable;

    /**
     * @var string $reply
     * @var User $user
     * @var User $from
     */
    protected $reply, $user, $from;

    /**
     * NewReply constructor.
     *
     * @param $user
     */
    public function __construct($reply, $user, $from)
    {
        $this->reply = $reply;
        $this->user = $user;
        $this->from = $from;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $subject = "=?UTF-8?B?". base64_encode($this->from->full_name . "在" . app_name() . "上回复了您的帖子") . "?=";
        return (new MailMessage())
            ->subject($subject)
            ->greeting($this->user->full_name . "，你好！")
            ->line($this->from->full_name . "回复了您的帖子，内容如下：")
            ->line("<hr>")
            ->line($this->reply['content'])
            ->line("<hr>")
            ->action("阅读原文", route("frontend.forum.assignment.view",
                [$this->reply['course_id'], $this->reply['assignment_id'], 'asc']))
            ->salutation("祝学习顺利");
    }
}
