<?php

namespace App\Http\Controllers\SW;

use App\Helpers\AssignmentPushNotification;
use App\Http\Controllers\APIController;
use Illuminate\Http\Request;

class SWController extends APIController
{
    /**
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $user = $request->user();

        $token = $user->createToken('service-worker');

        return $this->data($token);
    }

    /**
     * Service worker polling handler.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function poll(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return $this->error('Unauthorized', 401);
        }

        $notifications = collect([]);

        $publicAssignments = $user->getOngoingPublicAssignments()
            ->where('due_time', '>=', now()->addMinutes(29))
            ->where('due_time', '<', now()->addMinutes(30));
        $publicAssignmentsNotifications
            = AssignmentPushNotification::pushNotificationPublicCollection($publicAssignments);
        $notifications = $notifications->merge($publicAssignmentsNotifications);

        $personalAssignments = $user->getOngoingPersonalAssignments()
            ->where('due_time', '>=', now()->addMinutes(29))
            ->where('due_time', '<', now()->addMinutes(30));
        $personalAssignmentsNotifications
            = AssignmentPushNotification::pushNotificationPersonalCollection($personalAssignments);
        $notifications = $notifications->merge($personalAssignmentsNotifications);

        return $this->data($notifications);
    }
}
