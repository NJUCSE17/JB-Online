<?php

namespace App\Models\Forum\Traits\Method;

use Illuminate\Support\Facades\DB;

trait AssignmentMethod {

    /**
     * Mark assignment as finished
     */
    public function finish()
    {
        if (!\Auth::hasUser()) return;
        $records = DB::table('assignment_finish_records');
        $exists = $records->where('user_id', '=', \Auth::id())
            ->where('assignment_id', '=', $this->id)->exists();
        if (!$exists) {
            $records->insert([
                'user_id' => \Auth::id(),
                'assignment_id' => $this->id,
                'finished_at' => \Carbon\Carbon::now(),
            ]);
        }
    }

    /**
     * Reset assignment status
     */
    public function reset ()
    {
        if (!\Auth::hasUser()) return;
        $records = DB::table('assignment_finish_records');
        $exists = $records->where('user_id', '=', \Auth::id())
            ->where('assignment_id', '=', $this->id)->exists();
        if ($exists) {
            $records->where('user_id', '=', \Auth::id())
                ->where('assignment_id', '=', $this->id)->delete();
        }
    }
}