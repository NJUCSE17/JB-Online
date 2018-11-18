<?php

namespace App\Events\Backend\Forum\Problem;

use Illuminate\Queue\SerializesModels;

/**
 * Class ProblemUpdated.
 */
class ProblemUpdated
{
    use SerializesModels;

    /**
     * @var
     */
    public $problem;

    /**
     * @param $problem
     */
    public function __construct($problem)
    {
        $this->problem = $problem;
    }
}
