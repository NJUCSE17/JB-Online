<?php

namespace App\Observers;

use App\Models\Blog;

class BlogObserver
{
    /**
     * Handle the blog "created" event.
     *
     * @param  Blog  $blog
     *
     * @return void
     */
    public function created(Blog $blog)
    {
        //
    }

    /**
     * Handle the blog "updated" event.
     *
     * @param  Blog  $blog
     *
     * @return void
     */
    public function updated(Blog $blog)
    {
        //
    }

    /**
     * Handle the blog "deleted" event.
     *
     * @param  Blog  $blog
     *
     * @return void
     */
    public function deleted(Blog $blog)
    {
        //
    }

    /**
     * Handle the blog "restored" event.
     *
     * @param  Blog  $blog
     *
     * @return void
     */
    public function restored(Blog $blog)
    {
        //
    }

    /**
     * Handle the blog "force deleted" event.
     *
     * @param  Blog  $blog
     *
     * @return void
     */
    public function forceDeleted(Blog $blog)
    {
        //
    }
}
