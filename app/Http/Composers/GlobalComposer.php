<?php

namespace App\Http\Composers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

/**
 * Class GlobalComposer.
 */
class GlobalComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('logged_in_user', auth()->user());

        /* Get the theme of app */
        $theme = Session::has('theme') ? Session::get('theme') : 'light';
        if ($theme === 'auto') {
            $hour = Carbon::now()->hour;
            $theme = ($hour >= 7 && $hour <= 21) ? 'light' : 'dark';
        }
        $view->with('theme', $theme);
    }
}
