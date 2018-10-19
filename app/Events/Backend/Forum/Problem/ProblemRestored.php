<?php

namespace App\Events\Backend\Forum\Problem;

use Illuminate\Queue\SerializesModels;

/**
 * Class ProblemRestored.
 */
class ProblemRestored
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
