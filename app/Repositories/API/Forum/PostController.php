<?php

namespace App\Repositories\API\Forum;


use App\Models\Forum\Post;
use App\Repositories\BaseRepository;

class PostController extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Post::class;
    }
}