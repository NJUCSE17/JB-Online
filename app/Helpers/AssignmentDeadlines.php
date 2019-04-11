<?php

namespace App\Helpers;

use Carbon\Carbon;

class AssignmentDeadlines
{
    public static function DDLColor($assignment)
    {
        if (!isset($assignment->due_time)) {
            return "";
        } elseif (isset($assignment->finished_at)) {
            return "text-success";
        }

        $delta = Carbon::parse($assignment->due_time)->diffInDays();
        if ($delta < 1) {
            return "text-danger";
        } elseif ($delta < 2) {
            return "text-warning";
        } else {
            if ($delta < 5) {
                return "text-info";
            } else {
                return "text-dark";
            }
        }
    }

    public static function DDLForHuman($assignment)
    {
        if (!isset($assignment->due_time)) {
            return "";
        }
        $ddl = Carbon::parse($assignment->due_time);

        return $ddl->isoFormat("Y-MM-DD (ddd) H:mm:ss")." "
            .$ddl->diffForHumans(null, null, false, 2);
    }
}