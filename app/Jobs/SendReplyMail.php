<?php

namespace App\Jobs;

use App\Models\Auth\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\Frontend\Forum\NewReply;

class SendReplyMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string $reply
     * @var User $user
     * @var User $from
     */
    protected $reply, $user, $from;

    /**
     * Create a new job instance.
     *
     * @param mixed $maildata
     * @return void
     */
    public function __construct(array $maildata)
    {
        $this->reply = $maildata['reply'];
        $this->user = $maildata['user'];
        $this->from = $maildata['from'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Mail::send(new NewNotice($this->maildata));
        $this->user->notify(new NewReply($this->reply, $this->user, $this->from));
        \Log::info('Sent reply mail to ' . $this->user->full_name);
    }
}
