<?php

namespace App\Listeners\Backend\Forum\Course;

/**
 * Class CourseEventListener.
 */
class CourseEventListener
{
    /**
     * @param $event
     */
    public function onCreated($event)
    {
        \Log::info('Course Created');
    }

    /**
     * @param $event
     */
    public function onUpdated($event)
    {
        \Log::info('Course Updated');
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        \Log::info('Course Deleted');
    }

    /**
     * @param $event
     */
    public function onPermanentlyDeleted($event)
    {
        \Log::info('Course Permanently Deleted');
    }

    /**
     * @param $event
     */
    public function onRestored($event)
    {
        \Log::info('Course Restored');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            \App\Events\Backend\Forum\Course\CourseCreated::class,
            'App\Listeners\Backend\Forum\Course\CourseEventListener@onCreated'
        );

        $events->listen(
            \App\Events\Backend\Forum\Course\CourseUpdated::class,
            'App\Listeners\Backend\Forum\Course\CourseEventListener@onUpdated'
        );

        $events->listen(
            \App\Events\Backend\Forum\Course\CourseDeleted::class,
            'App\Listeners\Backend\Forum\Course\CourseEventListener@onDeleted'
        );

        $events->listen(
            \App\Events\Backend\Forum\Course\CoursePermanentlyDeleted::class,
            'App\Listeners\Backend\Forum\Course\CourseEventListener@onPermanentlyDeleted'
        );

        $events->listen(
            \App\Events\Backend\Forum\Course\CourseRestored::class,
            'App\Listeners\Backend\Forum\Course\CourseEventListener@onRestored'
        );
    }
}
