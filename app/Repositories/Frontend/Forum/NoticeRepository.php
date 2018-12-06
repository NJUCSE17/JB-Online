<?php

namespace App\Repositories\Frontend\Forum;

use App\Models\Forum\Notice;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;

/**
 * Class NoticeRepository.
 */
class NoticeRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Notice::class;
    }

    /**
     * @return mixed
     */
    public function getNotice()
    {
        return $this->model
            ->orderBy('updated_at', 'dec')
            ->first();
    }

    /**
     * @return mixed
     */
    public function APIGetNotice()
    {
        return $this->model
            ->orderBy('updated_at', 'dec')
            ->first(['content', 'updated_at']);
    }
}
