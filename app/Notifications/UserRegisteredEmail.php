<?php

namespace App\Notifications;

use App\Helpers\UserGreetings;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserRegisteredEmail extends Notification
{
    use Queueable;

    protected $admin;
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $admin, User $user)
    {
        $this->admin = $admin;
        $this->user = $user;
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
        $subject = "=?UTF-8?B?".base64_encode("来自".env('APP_NAME')
                ."的通知 - 新用户注册 - ".$this->user->student_id." ".$this->user->name)."?=";

        $message = (new MailMessage)
            ->subject($subject)
            ->greeting(UserGreetings::greet($this->admin))
            ->line(env('APP_NAME').'有新的用户注册，具体信息如下：')
            ->line('---')
            ->line('## '.$this->user->name)
            ->line('- 学号：'.$this->user->student_id)
            ->line('- 邮箱：'.$this->user->email)
            ->line('---')
            ->action('进入用户列表页', url(route('user.list')))
            ->salutation('祝您学习快乐');

        return $message;
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
