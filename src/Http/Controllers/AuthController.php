<?php

namespace Merlion\Http\Controllers;

use Merlion\Components\Renderable;

class AuthController
{
    public function getLoginPage()
    {
        return panel()->pageTitle(__('merlion::base.login'))->guest()->content(Renderable::make()->view('merlion::pages.auth.login'));
    }

    public function submitLogin()
    {
        if (!panel()->auth()->attempt(request()->only(panel()->getAuthCredential()))) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }

        return redirect()->intended(panel()->getHomeUrl());
    }

    public function logout()
    {
        panel()->auth()->logout();
        return response()->json([
            'action' => 'refresh',
        ]);
    }
}
