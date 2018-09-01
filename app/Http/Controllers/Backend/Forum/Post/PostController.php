<?php

namespace App\Http\Controllers\Backend\Forum\Post;

use App\Models\Forum\Assignment;
use App\Models\Forum\Post;
use App\Http\Controllers\Controller;
use App\Events\Backend\Forum\Post\PostDeleted;
use App\Repositories\Backend\Forum\PostRepository;
use App\Http\Requests\Backend\Forum\Post\ManagePostRequest;
use App\Http\Requests\Backend\Forum\Post\UpdatePostRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class PostController.
 */
class PostController extends Controller
{
    /**
     * @var PostRepository
     */
    protected $postRepository;

    /**
     * PostController constructor.
     *
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @param ManagePostRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ManagePostRequest $request)
    {
        return view('backend.forum.post.index')
            ->withPosts($this->postRepository->getPaginated(25));
    }

    /**
     * @param ManagePostRequest $request
     * @param Assignment $assignment
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function specific(ManagePostRequest $request, Assignment $assignment)
    {
        return view('backend.forum.post.index')
            ->withSpecificAssignment($assignment)
            ->withPosts($this->postRepository
                ->getPaginatedByAssignment($assignment, 25));
    }

    /**
     * @param ManagePostRequest $request
     * @param Post              $post
     *
     * @return mixed
     */
    public function show(ManagePostRequest $request, Post $post)
    {
        return view('backend.forum.post.show')
            ->withPost($post);
    }

    /**
     * @param ManagePostRequest    $request
     * @param Post                 $post
     *
     * @return mixed
     */
    public function edit(ManagePostRequest $request, Post $post)
    {
        return view('backend.forum.post.edit')
            ->withPost($post);
    }

    /**
     * @param UpdatePostRequest $request
     * @param Post              $post
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->only('content');
        $data['editor_id'] = Auth::id();
        $this->postRepository->update($post, $data);

        return redirect()->route('admin.forum.post.index')->withFlashSuccess(__('alerts.backend.posts.updated'));
    }

    /**
     * @param ManagePostRequest $request
     * @param Post              $post
     *
     * @return mixed
     * @throws \Exception
     */
    public function destroy(ManagePostRequest $request, Post $post)
    {
        $this->postRepository->deleteById($post->id);

        event(new PostDeleted($post));

        return redirect()->route('admin.forum.post.index')->withFlashSuccess(__('alerts.backend.posts.deleted'));
    }
}
