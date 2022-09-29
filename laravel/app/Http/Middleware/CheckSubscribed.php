<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class CheckSubscribed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(App::environment('local')) {
            $url_base = 'https://local-accounts.laravelwebsite.com';
        } else if(App::environment('production')) {
            $url_base = 'https://accounts.laravelwebsite.com';
        }

        $redirect = rawurlencode(secure_url('/'));

        if($request->user() && $request->user()->subscribed('product_three')) {
            return $next($request);
        } else if($request->user() && ! $request->user()->trialSet()) {
            return redirect($url_base . '/free-trial?redirect=' . $redirect . '&product=product_three');
        } else if($request->user() && ! $request->user()->onTrial()) {
            return redirect($url_base . '/subscribe?redirect=' . $redirect . '&product=product_three&trial=expired');
        } else {
            return $next($request);
        }

    }
}
