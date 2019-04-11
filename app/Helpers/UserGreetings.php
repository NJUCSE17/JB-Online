<?php

namespace App\Helpers;

use App\Models\User;
use Carbon\Carbon;

class UserGreetings
{
    /**
     * Generate greeting according to time.
     *
     * @param  User  $user
     *
     * @return string
     */
    public static function greet(User $user)
    {
        $nowHour = Carbon::now()->hour;
        $greetingTypes = [
            [6, '凌晨好'],
            [11, '早上好'],
            [14, '中午好'],
            [18, '下午好'],
            [24, '晚上好'],
        ];
        $greetingPrefix = "好";
        foreach ($greetingTypes as $greetingType) {
            if ($nowHour < $greetingType[0]) {
                $greetingPrefix = $greetingType[1];
                break;
            }
        }
        return $greetingPrefix."，".$user->name;
    }
}