<?php

namespace App\Events\Frontend\Forum\Post;

use Illuminate\Queue\SerializesModels;

/**
 * Class PostCreated.
 */
class PostCreated
{
    use SerializesModels;

    /**
     * @var
     */
    public $post;

    /**
     * @param $post
     */
    public function __construct($post)
    {
        $this->post = $post;
    }
}
