<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        $route = match (true) {
            $user->role('admin') => 'admin.dashboard',
            $user->role('user') => 'user.dashboard',
            default => 'home',
        };

        return redirect()->intended(route($route));
    }
}
