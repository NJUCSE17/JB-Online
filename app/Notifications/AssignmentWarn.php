<?php

namespace App\Notifications;

use App\Models\Auth\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AssignmentWarn extends Notification
{
    use Queueable;

    /**
     * @var User $user
     * @var string $content
     */
    protected $user, $content;

    /**
     * Create a new notification instance.
     *
     * @param $user
     * @param $content
     *
     * @return void
     */
    public function __construct($user, $content)
    {
        $this->user = $user;
        $this->content = $content;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $subject = "=?UTF-8?B?". base64_encode("来自" . app_name()
                ."的作业提示 - " . \Carbon\Carbon::now()->toDateString()) . "?=";

        return (new MailMessage())
            ->subject($subject)
            ->greeting($this->user->full_name . "，晚上好！")
            ->line("现在是" . \Carbon\Carbon::now()->toDateTimeString() . "，以下是今晚和明天需要提交的作业：")
            ->line("<hr>")
            ->line($this->content)
            ->line("<hr>")
            ->action("进入网站", route("frontend.index"))
            ->salutation("祝您晚安/熬夜快乐");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
