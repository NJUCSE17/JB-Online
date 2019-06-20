<?php

namespace App\Helpers;

use App\Models\Assignment;
use App\Models\PersonalAssignment;
use Carbon\Carbon;

class AssignmentPushNotification
{
    public static function pushNotificationPublic(Assignment $assignment)
    {
        $ddl = Carbon::parse($assignment->due_time);

        return [
            'title'   => '来自'.env('APP_NAME').'的作业提示',
            'options' => [
                'body'    => '课程“'.$assignment->course->name.'”的作业“'
                    .$assignment->name.'”将在30分钟内（'.
                    $ddl->format('H:i').'）截止。',
                'badge'   => env('APP_URL').'/favicon.png',
                'icon'    => env('APP_URL').'/favicon.png',
                'lang'    => 'zh-CN',
                'vibrate' => [100, 100, 100],
            ],
        ];
    }

    public static function pushNotificationPublicCollection($assignments)
    {
        $notifications = [];
        foreach ($assignments as $assignment) {
            $notifications[] = self::pushNotificationPublic($assignment);
        }

        return collect($notifications);
    }

    public static function pushNotificationPersonal(
        PersonalAssignment $personalAssignment
    ) {
        $ddl = Carbon::parse($personalAssignment->due_time);

        return [
            'title'   => '来自'.env('APP_NAME').'的作业提示',
            'options' => [
                'body'    => '您的个人作业“'.$personalAssignment->name.'”将在30分钟内（'.
                    $ddl->format('H:i').'）截止。',
                'badge'   => env('APP_URL').'/favicon.png',
                'icon'    => env('APP_URL').'/favicon.png',
                'lang'    => 'zh-CN',
                'vibrate' => [100, 100, 100],
            ],
        ];
    }

    public static function pushNotificationPersonalCollection(
        $personalAssignments
    ) {
        $notifications = [];
        foreach ($personalAssignments as $personalAssignment) {
            $notifications[]
                = self::pushNotificationPersonal($personalAssignment);
        }

        return collect($notifications);
    }
}