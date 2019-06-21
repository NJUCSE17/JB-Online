<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\AssignmentWarnEmail;
use Illuminate\Console\Command;

class SendAssignmentMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:send_assignment_mails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send assignment mails to users.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::all();
        foreach ($users as $user) {
            if (!$user->want_email) {
                echo "[Blocked] ".$user->id." - ".$user->name."\n";
            } else {
                $assignments = $user->getOngoingAssignments()
                    ->where('due_time', '>=', now())
                    ->where('due_time', '<=', now()->addDay()->endOfDay());
                if (!count($assignments)) {
                    echo "[Skipped] ".$user->id." - ".$user->name."\n";
                } else {
                    $user->notify(new AssignmentWarnEmail($user, $assignments));
                    echo "[Success] ".$user->id." - ".$user->name
                        ." [".count($assignments)." assignments]";
                }
            }
        }

        echo "Done sending assignment emails.\n";
        return 0;
    }
}
