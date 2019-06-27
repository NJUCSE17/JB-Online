<?php

namespace App\Notifications;

use App\Helpers\UserGreetings;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssignmentWarnEmail extends Notification
{
    use Queueable;

    protected $user;
    protected $assignments;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, $assignments)
    {
        $this->user = $user;
        $this->assignments = $assignments;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
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
     * @param  mixed  $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $subject = "=?UTF-8?B?".base64_encode("来自".env('APP_NAME')
                ."的作业提示 - ".now()->toDateString())."?=";

        $message = (new MailMessage)
            ->subject($subject)
            ->greeting(UserGreetings::greet($this->user))
            ->line('现在是'.now()->toDateTimeString().'，现在至明晚前总共有'
                .count($this->assignments).'个作业将要截止。')
            ->line('---');

        foreach ($this->assignments as $assignment) {
            if (isset($assignment->course_id)) {
                $message->line('## '.$assignment->course->name.' - '.$assignment->name);
            } else {
                $message->line('## 个人 - '.$assignment->name);
            }
            $message->line($assignment->content)
                ->line('**截止时间：'.$this->assignment->due_time.'**')
                ->line('');
        }

        $message->line('---')
            ->action('进入主页', url(route('home')))
            ->salutation('祝您学习快乐');

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
