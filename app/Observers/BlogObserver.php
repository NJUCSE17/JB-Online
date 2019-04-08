<?php

namespace App\Observers;

use App\Blog;

class BlogObserver
{
    /**
     * Handle the blog "created" event.
     *
     * @param  \App\Blog  $blog
     * @return void
     */
    public function created(Blog $blog)
    {
        //
    }

    /**
     * Handle the blog "updated" event.
     *
     * @param  \App\Blog  $blog
     * @return void
     */
    public function updated(Blog $blog)
    {
        //
    }

    /**
     * Handle the blog "deleted" event.
     *
     * @param  \App\Blog  $blog
     * @return void
     */
    public function deleted(Blog $blog)
    {
        //
    }

    /**
     * Handle the blog "restored" event.
     *
     * @param  \App\Blog  $blog
     * @return void
     */
    public function restored(Blog $blog)
    {
        //
    }

    /**
     * Handle the blog "force deleted" event.
     *
     * @param  \App\Blog  $blog
     * @return void
     */
    public function forceDeleted(Blog $blog)
    {
        //
    }
}
