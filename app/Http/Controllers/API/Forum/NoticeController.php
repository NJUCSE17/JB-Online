<?php
/**
 * Created by PhpStorm.
 * User: Tianyun Zhang
 * Date: 2019/1/19
 * Time: 21:22
 */

namespace App\Http\Controllers\API\Forum;


class NoticeController
{
    /**
     * @var NoticeController
     */
    protected $noticeController;

    /**
     * NoticeController constructor.
     * @param NoticeController $noticeController
     */
    public function __construct(NoticeController $noticeController)
    {
        $this->noticeController = $noticeController;
    }

    /**
     * Fetch the current notice.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotice(Request $request)
    {
        return response()->json([
            "data" => $this->noticeRepository->APIGetNotice(),
        ], 200);
    }
}