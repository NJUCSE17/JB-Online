<?php

namespace App\Repositories\Frontend\Forum;

use App\Exceptions\GeneralException;
use App\Models\Forum\Post;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use App\Events\Frontend\Forum\Post\PostCreated;
use App\Events\Frontend\Forum\Post\PostUpdated;

/**
 * Class PostRepository.
 */
class PostRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Post::class;
    }

    /**
     * @return mixed
     */
    public function getAllCount(): int
    {
        return $this->model
            ->count();
    }

    /**
     * @param int
     *
     * @return Post
     */
    public function findPostByID($id) {
        return $this->model
            ->find($id);
    }

    /**
     * @param array $data
     *
     * @return Post
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data) : Post
    {
        $parser = new \Parsedown();
        return DB::transaction(function () use ($data, $parser) {
            $post = parent::create([
                'course_id' => $data['course_id'],
                'assignment_id' => $data['assignment_id'],
                'parent_id' => $data['parent_id'],
                'user_id' => $data['user_id'],
                'editor_id' => $data['user_id'],
                'content' => $data['content'],
                'content_html' => $parser->text($data['content']),
            ]);

            if ($post) {
                event(new PostCreated($post));
                return $post;
            }

            throw new GeneralException(__('exceptions.backend.access.posts.create_error'));
        });
    }

    /**
     * @param Post  $post
     * @param array $data
     *
     * @return Post
     * @throws GeneralException
     * @throws \Exception
     * @throws \Throwable
     */
    public function update(Post $post, array $data) : Post
    {
        $parser = new \Parsedown();
        return DB::transaction(function () use ($post, $data, $parser) {
            if ($post->update([
                'content' => $data['content'],
                'content_html' => $parser->text($data['content']),
                'editor_id' => $data['editor_id'],
            ])) {
                event(new PostUpdated($post));
                return $post;
            }

            throw new GeneralException(__('exceptions.backend.access.posts.update_error'));
        });
    }
}
