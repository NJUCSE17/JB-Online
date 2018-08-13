<?php

namespace App\Repositories\Backend\Forum;

use App\Models\Forum\Notice;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use App\Events\Backend\Forum\Notice\NoticeCreated;
use App\Events\Backend\Forum\Notice\NoticeUpdated;
use App\Events\Backend\Forum\Notice\NoticeRestored;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Events\Backend\Forum\Notice\NoticePermanentlyDeleted;

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
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc') : LengthAwarePaginator
    {
        return $this->model
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getDeletedPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc') : LengthAwarePaginator
    {
        return $this->model
            ->onlyTrashed()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }
    
    /**
     * @param array $data
     *
     * @return Notice
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data) : Notice
    {
        return DB::transaction(function () use ($data) {
            $notice = parent::create([
                'content' => $data['content'],
                'user_id' => $data['user_id'],
            ]);

            if ($notice) {
                event(new NoticeCreated($notice));
                return $notice;
            }

            throw new GeneralException(__('exceptions.backend.access.notices.create_error'));
        });
    }

    /**
     * @param Notice  $notice
     * @param array $data
     *
     * @return Notice
     * @throws GeneralException
     * @throws \Exception
     * @throws \Throwable
     */
    public function update(Notice $notice, array $data) : Notice
    {
        return DB::transaction(function () use ($notice, $data) {
            if ($notice->update([
                'content' => $data['content'],
                'user_id' => $data['user_id'],
            ])) {
                event(new NoticeUpdated($notice));
                return $notice;
            }

            throw new GeneralException(__('exceptions.backend.access.notices.update_error'));
        });
    }

    /**
     * @param Notice $notice
     *
     * @return Notice
     * @throws GeneralException
     * @throws \Exception
     * @throws \Throwable
     */
    public function forceDelete(Notice $notice) : Notice
    {
        if (is_null($notice->deleted_at)) {
            throw new GeneralException(__('exceptions.backend.access.notices.delete_first'));
        }

        return DB::transaction(function () use ($notice) {
            if ($notice->forceDelete()) {
                event(new NoticePermanentlyDeleted($notice));
                return $notice;
            }

            throw new GeneralException(__('exceptions.backend.access.notices.delete_error'));
        });
    }

    /**
     * @param Notice $notice
     *
     * @return Notice
     * @throws GeneralException
     */
    public function restore(Notice $notice) : Notice
    {
        if (is_null($notice->deleted_at)) {
            throw new GeneralException(__('exceptions.backend.access.notices.cant_restore'));
        }

        if ($notice->restore()) {
            event(new NoticeRestored($notice));
            return $notice;
        }

        throw new GeneralException(__('exceptions.backend.access.notices.restore_error'));
    }
}
