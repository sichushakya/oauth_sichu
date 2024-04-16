<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GithubController extends Controller
{
    /**
     * To Github for authentication
     *
     * @param null
     *
     */
    public function toGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Create or Updates a Github authenticated user
     *
     * @param null
     *
     */
    public function callback()
    {
        $githubUser = Socialite::driver('github')->user();

        //dd($githubUser);

        $user = User::updateOrCreate([
            'github_id' => $githubUser->id,
        ],[
            'name' => $githubUser->name,
            'email' => $githubUser->email,
        ]);

        Auth::login($user);

        $notification = [
            'message' => 'You have successfully logged in',
            'color' => '#3b3'
        ];

        return redirect()->route('form')->with(compact('notification'));
    }
}
