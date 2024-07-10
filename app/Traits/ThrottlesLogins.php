<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

trait ThrottlesLogins
{
    protected function hasTooManyLoginAttempts(Request $request)
    {
        $key = $this->throttleKey($request);
        RateLimiter::hit($key, 60); // Increment the login attempts
        return RateLimiter::tooManyAttempts($key, 6);
    }

    protected function incrementLoginAttempts(Request $request)
    {
        $key = $this->throttleKey($request);

        RateLimiter::hit($key, 60); // Increment the login attempts
        $attempts = RateLimiter::attempts($key);
        return $attempts;
    }

    protected function throttleKey(Request $request)
    {
        return mb_strtolower($request->input('npk')) . '|' . $request->ip();
    }

    protected function clearLoginAttempts(Request $request)
    {
        $key = $this->throttleKey($request);
        RateLimiter::clear($key);
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        return redirect("/login")->with('error', 'Too many login attempts. Please try again in ' . $seconds . ' seconds.');
    }
}
