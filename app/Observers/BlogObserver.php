<?php

namespace App\Observers;

use App\Models\BlogFeed;

class BlogObserver
{
    /**
     * Handle the blog "created" event.
     *
     * @param  BlogFeed  $blog
     *
     * @return void
     */
    public function created(BlogFeed $blog)
    {
        //
    }

    /**
     * Handle the blog "updated" event.
     *
     * @param  BlogFeed  $blog
     *
     * @return void
     */
    public function updated(BlogFeed $blog)
    {
        //
    }

    /**
     * Handle the blog "deleted" event.
     *
     * @param  BlogFeed  $blog
     *
     * @return void
     */
    public function deleted(BlogFeed $blog)
    {
        //
    }

    /**
     * Handle the blog "restored" event.
     *
     * @param  BlogFeed  $blog
     *
     * @return void
     */
    public function restored(BlogFeed $blog)
    {
        //
    }

    /**
     * Handle the blog "force deleted" event.
     *
     * @param  BlogFeed  $blog
     *
     * @return void
     */
    public function forceDeleted(BlogFeed $blog)
    {
        //
    }
}
