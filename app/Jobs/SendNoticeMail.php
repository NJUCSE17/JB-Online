<?php

namespace App\Jobs;

use App\Models\Auth\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\Backend\Forum\NewNotice;

class SendNoticeMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string $notice
     * @var User $user
     */
    protected $notice, $user;

    /**
     * Create a new job instance.
     *
     * @param mixed $maildata
     * @return void
     */
    public function __construct(array $maildata)
    {
        $this->notice = $maildata['notice'];
        $this->user = $maildata['user'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Mail::send(new NewNotice($this->maildata));
        $this->user->notify(new NewNotice($this->user, $this->notice));
        \Log::info('Sent notice mail to ' . $this->user->full_name);
    }
}
