<?php

namespace App\Http\Controllers\Backend\Forum\Post;

use App\Models\Forum\Post;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Forum\PostRepository;
use App\Http\Requests\Backend\Forum\Post\ManagePostRequest;

/**
 * Class PostStatusController.
 */
class PostStatusController extends Controller
{
    /**
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @param ManagePostRequest $request
     *
     * @return mixed
     */
    public function getDeleted(ManagePostRequest $request)
    {
        return view('backend.forum.post.deleted')
            ->withPosts($this->postRepository->getDeletedPaginated(25, 'id', 'asc'));
    }

    /**
     * @param ManagePostRequest $request
     * @param Post              $deletedPost
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function delete(ManagePostRequest $request, Post $deletedPost)
    {
        $this->postRepository->forceDelete($deletedPost);

        return redirect()->route('admin.forum.post.deleted')->withFlashSuccess(__('alerts.backend.posts.deleted_permanently'));
    }

    /**
     * @param ManagePostRequest $request
     * @param Post              $deletedPost
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function restore(ManagePostRequest $request, Post $deletedPost)
    {
        $this->postRepository->restore($deletedPost);

        return redirect()->route('admin.forum.post.deleted')->withFlashSuccess(__('alerts.backend.posts.restored'));
    }
}
