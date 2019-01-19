<?php

namespace App\Http\Controllers;

/**
 * Class LanguageController.
 */
class StyleController extends Controller
{
    /**
     * @param $locale
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function lang($locale)
    {
        if (array_key_exists($locale, config('locale.languages'))) {
            session()->put('locale', $locale);
        }

        return redirect()->back();
    }

    /**
     * @param $theme
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function theme($theme)
    {
        if (array_key_exists($theme, config('theme.themes'))) {
            session()->put('theme', $theme);
        }

        return redirect()->back();
    }
}
