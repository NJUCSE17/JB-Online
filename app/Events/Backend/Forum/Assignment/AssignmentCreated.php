<?php

namespace App\Events\Backend\Forum\Assignment;

use Illuminate\Queue\SerializesModels;

/**
 * Class AssignmentCreated.
 */
class AssignmentCreated
{
    use SerializesModels;

    /**
     * @var
     */
    public $assignment;

    /**
     * @param $assignment
     */
    public function __construct($assignment)
    {
        $this->assignment = $assignment;
    }
}