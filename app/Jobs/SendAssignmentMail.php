<?php

namespace App\Jobs;

use App\Models\Auth\User;
use App\Notifications\AssignmentWarn;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendAssignmentMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User $user
     * @var string $content
     */
    protected $user, $content;

    /**
     * Create a new job instance.
     *
     * @param array $maildata
     * @return void
     */
    public function __construct(array $maildata)
    {
        $this->user = $maildata['user'];
        $this->content = $maildata['content'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->notify(new AssignmentWarn($this->user, $this->content));
        \Log::info('Sent assignment warning to ' . $this->user->full_name);
    }
}
