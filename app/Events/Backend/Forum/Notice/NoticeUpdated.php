<?php

namespace App\Events\Backend\Forum\Notice;

use Illuminate\Queue\SerializesModels;

/**
 * Class NoticeUpdated.
 */
class NoticeUpdated
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
