<?php

namespace App\Http\Controllers\Frontend\Forum;

use App\Models\Forum\Post;
use App\Models\Forum\Course;
use App\Models\Forum\Assignment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Frontend\Forum\PostRepository;
use App\Http\Requests\Frontend\Forum\Post\StorePostRequest;
use App\Http\Requests\Frontend\Forum\Post\ManagePostRequest;
use App\Http\Requests\Frontend\Forum\Post\UpdatePostRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\Frontend\Post\SendReply;

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
     * @param StorePostRequest $request
     * @param Course $course
     * @param Assignment $assignment
     *
     * @return mixed
     * @throws \Throwable
     */
    public function store(StorePostRequest $request, Course $course, Assignment $assignment)
    {
        $data = $request->only('parent_id', 'content');
        $data['user_id'] = Auth::id();
        $data['course_id'] = $course->id;
        $data['assignment_id'] = $assignment->id;

        $this->postRepository->create($data);

        if ($data['parent_id'] != 0 && config('mail.password') != null) {
            Mail::send(new SendReply($request, $data));
        }

        return redirect()->route('frontend.forum.assignment.view', [$course, $assignment, 'dec'])
            ->withFlashSuccess(__('alerts.frontend.posts.created'));
    }

    /**
     * @param ManagePostRequest    $request
     * @param Course               $course
     * @param Assignment           $assignment
     * @param Post                 $post
     *
     * @return mixed
     */
    public function edit(ManagePostRequest $request, Course $course, Assignment $assignment, Post $post)
    {
        return view('frontend.forum.post.edit')
            ->withCourse($course)
            ->withAssignment($assignment)
            ->withPost($post);
    }

    /**
     * @param UpdatePostRequest    $request
     * @param Course               $course
     * @param Assignment           $assignment
     * @param Post                 $post
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(UpdatePostRequest $request, Course $course, Assignment $assignment, Post $post)
    {
        $data = $request->only('content');
        $data['editor_id'] = Auth::id();
        $this->postRepository->update($post, $data);

        return redirect()->route('frontend.forum.assignment.view', [$course, $assignment, 'dec  '])
            ->withFlashSuccess(__('alerts.backend.posts.updated'));
    }
}
