<?php

namespace App\Repositories\Backend\Forum;

use App\Models\Forum\Assignment;
use App\Models\Forum\Post;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use App\Events\Backend\Forum\Post\PostUpdated;
use App\Events\Backend\Forum\Post\PostRestored;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Events\Backend\Forum\Post\PostPermanentlyDeleted;

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
    public function getCount() : int
    {
        return $this->model
            ->count();
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
     * @param Assignment $assignment
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getPaginatedByAssignment(Assignment $assignment, $paged = 25, $orderBy = 'created_at',
                                         $sort = 'desc') : LengthAwarePaginator
    {
        return $this->model
            ->where('assignment_id', $assignment->id)
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

    /**
     * @param Post $post
     *
     * @return Post
     * @throws GeneralException
     * @throws \Exception
     * @throws \Throwable
     */
    public function forceDelete(Post $post) : Post
    {
        if (is_null($post->deleted_at)) {
            throw new GeneralException(__('exceptions.backend.access.posts.delete_first'));
        }

        return DB::transaction(function () use ($post) {
            if ($post->forceDelete()) {
                event(new PostPermanentlyDeleted($post));
                return $post;
            }

            throw new GeneralException(__('exceptions.backend.access.posts.delete_error'));
        });
    }

    /**
     * @param Post $post
     *
     * @return Post
     * @throws GeneralException
     */
    public function restore(Post $post) : Post
    {
        if (is_null($post->deleted_at)) {
            throw new GeneralException(__('exceptions.backend.access.posts.cant_restore'));
        }

        if ($post->restore()) {
            event(new PostRestored($post));
            return $post;
        }

        throw new GeneralException(__('exceptions.backend.access.posts.restore_error'));
    }
}
