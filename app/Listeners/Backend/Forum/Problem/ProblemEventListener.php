<?php

namespace App\Listeners\Backend\Forum\Problem;

/**
 * Class ProblemEventListener.
 */
class ProblemEventListener
{
    /**
     * @param $event
     */
    public function onCreated($event)
    {
        \Log::info('Problem Created');
    }

    /**
     * @param $event
     */
    public function onUpdated($event)
    {
        \Log::info('Problem Updated');
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        \Log::info('Problem Deleted');
    }

    /**
     * @param $event
     */
    public function onPermanentlyDeleted($event)
    {
        \Log::info('Problem Permanently Deleted');
    }

    /**
     * @param $event
     */
    public function onRestored($event)
    {
        \Log::info('Problem Restored');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            \App\Events\Backend\Forum\Problem\ProblemCreated::class,
            'App\Listeners\Backend\Forum\Problem\ProblemEventListener@onCreated'
        );

        $events->listen(
            \App\Events\Backend\Forum\Problem\ProblemUpdated::class,
            'App\Listeners\Backend\Forum\Problem\ProblemEventListener@onUpdated'
        );

        $events->listen(
            \App\Events\Backend\Forum\Problem\ProblemDeleted::class,
            'App\Listeners\Backend\Forum\Problem\ProblemEventListener@onDeleted'
        );

        $events->listen(
            \App\Events\Backend\Forum\Problem\ProblemPermanentlyDeleted::class,
            'App\Listeners\Backend\Forum\Problem\ProblemEventListener@onPermanentlyDeleted'
        );

        $events->listen(
            \App\Events\Backend\Forum\Problem\ProblemRestored::class,
            'App\Listeners\Backend\Forum\Problem\ProblemEventListener@onRestored'
        );
    }
}
