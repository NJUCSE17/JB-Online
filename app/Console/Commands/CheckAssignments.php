<?php

namespace App\Console\Commands;

use App\Jobs\SendAssignmentMail;
use App\Repositories\Backend\Auth\UserRepository;
use App\Repositories\Backend\Forum\AssignmentRepository;
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
        $targetDatetime = \Carbon\Carbon::now()->addDay(2)->startOfDay();
        $onGoingAssignments = $this->assignmentRepository->getOngoingAssignments();
        $warningAssignments = array();
        foreach ($onGoingAssignments as $assignment) {
            if ($targetDatetime->gte($assignment->due_time)) {
                $warningAssignments[] = $assignment;
            }
        }

        if (count($warningAssignments)) {
            $content = "<ul style='list-style-type: none;'>";
            foreach ($warningAssignments as $assignment) {
                $content = $content . "<li><h1>"
                    . $assignment->name . "</h1><p>" . $assignment->content
                    . "</p><p style='text-align: right !important'>" . __('labels.general.ddl')
                    . " " . $assignment->due_time . "</p></li>";
            }
            $content = $content . "</ul>";

            $users = $this->userRepository->get();
            foreach ($users as $user) {
                if ($user->isConfirmed()) {
                    SendAssignmentMail::dispatch(array(
                        'content' => $content,
                        'user'    => $user,
                    ));
                }
            }
        }

        return $this;
    }
}
