<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Closure;
use App\User;

class LogoutUsers
{
    /**
     * Handle an incoming request.
     * Source:https://stackoverflow.com/questions/41440352/laravel-force-logout-of-specific-user-by-user-id
     * It needs the boolean logout field in user table.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // You might want to create a method on your model to
        // prevent direct access to the `logout` property. Something
        // like `markedForLogout()` maybe.
        if (! empty($user->logout)) {
            // Not for the next time!
            // Maybe a `unmarkForLogout()` method is appropriate here.
            $user->logout = false;
            $user->save();

            // Log her out
            Auth::logout();
            Session::flush();
            Session::save();
            return redirect()->route('login');
        }
        return $next($request);
    }
}
