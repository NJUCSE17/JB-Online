<?php

namespace App\Listeners\Backend\Forum\Post;

/**
 * Class PostEventListener.
 */
class PostEventListener
{
    /**
     * @param $event
     */
    public function onUpdated($event)
    {
        \Log::info('Post Updated');
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        \Log::info('Post Deleted');
    }

    /**
     * @param $event
     */
    public function onPermanentlyDeleted($event)
    {
        \Log::info('Post Permanently Deleted');
    }

    /**
     * @param $event
     */
    public function onRestored($event)
    {
        \Log::info('Post Restored');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            \App\Events\Backend\Forum\Post\PostUpdated::class,
            'App\Listeners\Backend\Forum\Post\PostEventListener@onUpdated'
        );

        $events->listen(
            \App\Events\Backend\Forum\Post\PostDeleted::class,
            'App\Listeners\Backend\Forum\Post\PostEventListener@onDeleted'
        );

        $events->listen(
            \App\Events\Backend\Forum\Post\PostPermanentlyDeleted::class,
            'App\Listeners\Backend\Forum\Post\PostEventListener@onPermanentlyDeleted'
        );

        $events->listen(
            \App\Events\Backend\Forum\Post\PostRestored::class,
            'App\Listeners\Backend\Forum\Post\PostEventListener@onRestored'
        );
    }
}
