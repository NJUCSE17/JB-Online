<?php

namespace App\Helpers;


use App\Http\Resources\AssignmentResourceCollection;
use App\Http\Resources\PersonalAssignmentResourceCollection;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class AssignmentMerger
{
    public static function mergeAssignments(
        Collection $publicAssignments,
        Collection $privateAssignments
    ) {
        $publicAssignmentArray
            = (new AssignmentResourceCollection($publicAssignments))->toArray(null);
        $privateAssignmentArray
            = (new PersonalAssignmentResourceCollection($privateAssignments))->toArray(null);
        foreach ($publicAssignmentArray as $i => $publicAssignment) {
            $publicAssignmentArray[$i]['type'] = 'public';
            $publicAssignmentArray[$i]['api'] = route('api.assignment.index');
            $publicAssignmentArray[$i]['due_time_human']
                = Carbon::parse($publicAssignmentArray[$i]['due_time'])
                ->diffForHumans(null, null, false, 2);
        }
        foreach ($privateAssignmentArray as $i => $privateAssignment) {
            $privateAssignmentArray[$i]['type'] = 'private';
            $privateAssignmentArray[$i]['api']
                = route('api.personalAssignment.index');
            $privateAssignmentArray[$i]['due_time_human']
                = Carbon::parse($privateAssignmentArray[$i]['due_time'])
                ->diffForHumans(null, null, false, 2);

        }

        $assignments = array_merge($publicAssignmentArray,
            $privateAssignmentArray);
        usort($assignments, function ($a, $b) {
            if ($a['due_time'] === $b['due_time']) {
                return 0;
            } else {
                return $a['due_time'] < $b['due_time'] ? -1 : 1;
            }
        });

        return $assignments;
    }
}