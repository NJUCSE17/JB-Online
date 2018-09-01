<?php

namespace App\Http\Controllers\Backend\Forum\Notice;

use App\Models\Forum\Notice;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Forum\NoticeRepository;
use App\Http\Requests\Backend\Forum\Notice\ManageNoticeRequest;

/**
 * Class NoticeStatusController.
 */
class NoticeStatusController extends Controller
{
    /**
     * @var NoticeRepository
     */
    protected $noticeRepository;

    /**
     * @param NoticeRepository $noticeRepository
     */
    public function __construct(NoticeRepository $noticeRepository)
    {
        $this->noticeRepository = $noticeRepository;
    }

    /**
     * @param ManageNoticeRequest $request
     *
     * @return mixed
     */
    public function getDeleted(ManageNoticeRequest $request)
    {
        return view('backend.forum.notice.deleted')
            ->withNotices($this->noticeRepository->getDeletedPaginated(25, 'id', 'asc'));
    }

    /**
     * @param ManageNoticeRequest $request
     * @param Notice              $deletedNotice
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function delete(ManageNoticeRequest $request, Notice $deletedNotice)
    {
        $this->noticeRepository->forceDelete($deletedNotice);

        return redirect()->route('admin.forum.notice.deleted')->withFlashSuccess(__('alerts.backend.notices.deleted_permanently'));
    }

    /**
     * @param ManageNoticeRequest $request
     * @param Notice              $deletedNotice
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function restore(ManageNoticeRequest $request, Notice $deletedNotice)
    {
        $this->noticeRepository->restore($deletedNotice);

        return redirect()->route('admin.forum.notice.deleted')->withFlashSuccess(__('alerts.backend.notices.restored'));
    }
}
