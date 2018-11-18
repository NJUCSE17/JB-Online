<?php

namespace App\Console\Commands;

use App\Jobs\SendAssignmentMail;
use App\Repositories\Backend\Auth\UserRepository;
use App\Repositories\Backend\Forum\AssignmentRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckAssignments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forum:checkassignments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if there are assignments due in hours and send notification if so.';

    /**
     * @var UserRepository $userRepository
     * @var AssignmentRepository $assignmentRepository
     */
    protected $userRepository, $assignmentRepository;

    /**
     * Create a new command instance.
     *
     * @param UserRepository $userRepository
     * @param AssignmentRepository $assignmentRepository
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository,
                                AssignmentRepository $assignmentRepository)
    {
        $this->userRepository = $userRepository;
        $this->assignmentRepository = $assignmentRepository;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "Checking assignments at " . Carbon::now() . "\n";

        $users = $this->userRepository->get();
        foreach ($users as $user) {
            if ($user->isConfirmed() && $user->wantMail()) {
                echo "Checking " . $user->id . "-" . $user->full_name . "... ";
                $assignments = $this->assignmentRepository->getMailAssignments($user->id);
                echo "has " . count($assignments) . " assignments. ";
                if (count($assignments)) {
                    $content = "<ul style='list-style-type: none;'>";
                    foreach ($assignments as $assignment) {
                        $content = $content . "<li><h1><a href='" . $assignment->assignment_link . "'>"
                            . $assignment->name . "</a></h1><p>" . $assignment->content
                            . "</p><div style='text-align: right;'>"
                            . $assignment->ddl_badge_content . "</div></li>";
                    }
                    $content = $content . "</ul>";
                    SendAssignmentMail::dispatch(array(
                        'content' => $content,
                        'user'    => $user,
                    ));
                    echo "Queued sending assignment mail.\n";
                }
            } else {
                echo "Skipping for " . $user->full_name . "\n";
            }
        }
        echo "Done handling assignment mails.";
        return $this;
    }
}
