<?php

namespace App\Listeners\Backend\Forum\Assignment;

/**
 * Class AssignmentEventListener.
 */
class AssignmentEventListener
{
    /**
     * @param $event
     */
    public function onCreated($event)
    {
        \Log::info('Assignment Created');
    }

    /**
     * @param $event
     */
    public function onUpdated($event)
    {
        \Log::info('Assignment Updated');
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        \Log::info('Assignment Deleted');
    }

    /**
     * @param $event
     */
    public function onPermanentlyDeleted($event)
    {
        \Log::info('Assignment Permanently Deleted');
    }

    /**
     * @param $event
     */
    public function onRestored($event)
    {
        \Log::info('Assignment Restored');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            \App\Events\Backend\Forum\Assignment\AssignmentCreated::class,
            'App\Listeners\Backend\Forum\Assignment\AssignmentEventListener@onCreated'
        );

        $events->listen(
            \App\Events\Backend\Forum\Assignment\AssignmentUpdated::class,
            'App\Listeners\Backend\Forum\Assignment\AssignmentEventListener@onUpdated'
        );

        $events->listen(
            \App\Events\Backend\Forum\Assignment\AssignmentDeleted::class,
            'App\Listeners\Backend\Forum\Assignment\AssignmentEventListener@onDeleted'
        );

        $events->listen(
            \App\Events\Backend\Forum\Assignment\AssignmentPermanentlyDeleted::class,
            'App\Listeners\Backend\Forum\Assignment\AssignmentEventListener@onPermanentlyDeleted'
        );

        $events->listen(
            \App\Events\Backend\Forum\Assignment\AssignmentRestored::class,
            'App\Listeners\Backend\Forum\Assignment\AssignmentEventListener@onRestored'
        );
    }
}
