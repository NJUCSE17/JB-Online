<?php

namespace App\Notifications\Backend\Forum;

use App\Models\Auth\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Class NewNotice.
 */
class NewNotice extends Notification
{
    use Queueable;

    /**
     * @var User $user
     * @var string $notice
     */
    protected $user, $notice;

    /**
     * NewNotice constructor.
     *
     * @param $user
     */
    public function __construct($user, $notice)
    {
        $this->user = $user;
        $this->notice = $notice;
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
        $subject = "=?UTF-8?B?". base64_encode("来自" . app_name() . "的新系统通知") . "?=";
        return (new MailMessage())
            ->subject($subject)
            ->greeting($this->user->full_name . "，你好！")
            ->line("管理员发布了新通知，请您阅读。")
            ->line("<hr>")
            ->line($this->notice['content'])
            ->line("<hr>")
            ->action("阅读原文", route("frontend.index"))
            ->salutation("祝学习顺利");
    }
}
