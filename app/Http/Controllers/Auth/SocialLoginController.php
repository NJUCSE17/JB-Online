<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    /**
     * Handle socialite login event
     * @return mixed
     */
    public function githubRedirect()
    {
        // Redirect to an outside login page
        return Socialite::driver('github')->redirect();
    }

    /**
     * Handle socialite login callback
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function githubCallback()
    {
        // Try to fetch the user from callback info
        // TODO: USE TRY CATCH TO HANDLE WITH ERROR
        $userData = Socialite::driver('github')->user();
        $email = $userData->email;
        // TODO: HANDLE WHAT IF EMAIL IS NULL (GITHUB ACCOUNT IS INVALID)
        $user = User::where('email', $email)->first();
        $avatar = $userData->avatar;

        if ($user) {
            // TODO: CHECK USER VALIDITY

            // Successfully login as a user
            auth()->login($user, true);
            // Save GitHub avatar in database
            $user->avatar_github = $avatar;
            $user->save();
            // TODO: FIRE LOGIN EVENT

            // return to intended url or home page
            return redirect()->intended(route('home'));
        } else {
            // User does not exist, redirect to login page
            return redirect(route('login'))
                ->with(['error' => "Invalid callback info."]);
        }
    }
}
