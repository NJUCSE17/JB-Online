<?php

namespace App\Http\Composers;

use Carbon\Carbon;
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
        $this->setTheme($view);
    }

    public function setTheme(View $view)
    {
        $view->with('appTheme', 'darkly');
    }
}
