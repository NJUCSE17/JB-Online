<?php

namespace App\Repositories\API\Forum;


use App\Models\Forum\Notice;
use App\Repositories\BaseRepository;

class NoticeRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Notice::class;
    }
}