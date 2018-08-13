<?php

namespace App\Listeners\Backend\Forum\Notice;

/**
 * Class NoticeEventListener.
 */
class NoticeEventListener
{
    /**
     * @param $event
     */
    public function onCreated($event)
    {
        \Log::info('Notice Created');
    }

    /**
     * @param $event
     */
    public function onUpdated($event)
    {
        \Log::info('Notice Updated');
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        \Log::info('Notice Deleted');
    }

    /**
     * @param $event
     */
    public function onPermanentlyDeleted($event)
    {
        \Log::info('Notice Permanently Deleted');
    }

    /**
     * @param $event
     */
    public function onRestored($event)
    {
        \Log::info('Notice Restored');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            \App\Events\Backend\Forum\Notice\NoticeCreated::class,
            'App\Listeners\Backend\Forum\Notice\NoticeEventListener@onCreated'
        );

        $events->listen(
            \App\Events\Backend\Forum\Notice\NoticeUpdated::class,
            'App\Listeners\Backend\Forum\Notice\NoticeEventListener@onUpdated'
        );

        $events->listen(
            \App\Events\Backend\Forum\Notice\NoticeDeleted::class,
            'App\Listeners\Backend\Forum\Notice\NoticeEventListener@onDeleted'
        );

        $events->listen(
            \App\Events\Backend\Forum\Notice\NoticePermanentlyDeleted::class,
            'App\Listeners\Backend\Forum\Notice\NoticeEventListener@onPermanentlyDeleted'
        );

        $events->listen(
            \App\Events\Backend\Forum\Notice\NoticeRestored::class,
            'App\Listeners\Backend\Forum\Notice\NoticeEventListener@onRestored'
        );
    }
}
