<?php

namespace App\Events\Backend\Forum\Assignment;

use Illuminate\Queue\SerializesModels;

/**
 * Class AssignmentDeleted.
 */
class AssignmentDeleted
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
