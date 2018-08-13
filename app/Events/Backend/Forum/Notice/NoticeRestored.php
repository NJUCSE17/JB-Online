<?php

namespace App\Events\Backend\Forum\Notice;

use Illuminate\Queue\SerializesModels;

/**
 * Class NoticeRestored.
 */
class NoticeRestored
{
    use SerializesModels;

    /**
     * @var
     */
    public $notice;

    /**
     * @param $notice
     */
    public function __construct($notice)
    {
        $this->notice = $notice;
    }
}
