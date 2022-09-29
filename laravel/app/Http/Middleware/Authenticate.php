<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\App;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if(App::environment('local')) {
                $url = 'https://local-accounts.laravelwebsite.com/login?redirect=';
            }
            if(App::environment('production')) {
                $url = 'https://accounts.laravelwebsite.com/login?redirect=';
            }

            return $url . rawurlencode($request->url()) . '&service=Product_Three';
        }
    }
}
