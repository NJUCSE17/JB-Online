<?php

namespace App\Http\Controllers\Backend\Forum\Notice;

use App\Models\Forum\Notice;
use App\Http\Controllers\Controller;
use App\Events\Backend\Forum\Notice\NoticeDeleted;
use App\Repositories\Backend\Forum\NoticeRepository;
use App\Http\Requests\Backend\Forum\Notice\StoreNoticeRequest;
use App\Http\Requests\Backend\Forum\Notice\ManageNoticeRequest;
use App\Http\Requests\Backend\Forum\Notice\UpdateNoticeRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class NoticeController.
 */
class NoticeController extends Controller
{
    /**
     * @var NoticeRepository
     */
    protected $noticeRepository;

    /**
     * NoticeController constructor.
     *
     * @param NoticeRepository $noticeRepository
     */
    public function __construct(NoticeRepository $noticeRepository)
    {
        $this->noticeRepository = $noticeRepository;
    }

    /**
     * @param ManageNoticeRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ManageNoticeRequest $request)
    {
        return view('backend.forum.notice.index')
            ->withNotices($this->noticeRepository->getPaginated(25));
    }

    /**
     * @param ManageNoticeRequest    $request
     *
     * @return mixed
     */
    public function create(ManageNoticeRequest $request)
    {
        return view('backend.forum.notice.create');
    }

    /**
     * @param StoreNoticeRequest $request
     *
     * @return mixed
     * @throws \Throwable
     */
    public function store(StoreNoticeRequest $request)
    {

        $data = $request->only('content');
        $data['user_id'] = Auth::id();
        $this->noticeRepository->create($data);

        return redirect()->route('admin.forum.notice.index')->withFlashSuccess(__('alerts.backend.notices.created'));
    }


    /**
     * @param ManageNoticeRequest $request
     * @param Notice              $notice
     *
     * @return mixed
     */
    public function show(ManageNoticeRequest $request, Notice $notice)
    {
        return view('backend.forum.notice.show')
            ->withNotice($notice);
    }

    /**
     * @param ManageNoticeRequest    $request
     * @param Notice                 $notice
     *
     * @return mixed
     */
    public function edit(ManageNoticeRequest $request, Notice $notice)
    {
        return view('backend.forum.notice.edit')
            ->withNotice($notice);
    }

    /**
     * @param UpdateNoticeRequest $request
     * @param Notice              $notice
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(UpdateNoticeRequest $request, Notice $notice)
    {
        $data = $request->only('content');
        $data['user_id'] = Auth::id();
        $this->noticeRepository->update($notice, $data);

        return redirect()->route('admin.forum.notice.index')->withFlashSuccess(__('alerts.backend.notices.updated'));
    }

    /**
     * @param ManageNoticeRequest $request
     * @param Notice              $notice
     *
     * @return mixed
     * @throws \Exception
     */
    public function destroy(ManageNoticeRequest $request, Notice $notice)
    {
        $this->noticeRepository->deleteById($notice->id);

        event(new NoticeDeleted($notice));

        return redirect()->route('admin.forum.notice.deleted')->withFlashSuccess(__('alerts.backend.notices.deleted'));
    }
}
