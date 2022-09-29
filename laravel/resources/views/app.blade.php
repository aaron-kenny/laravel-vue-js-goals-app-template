<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#171717">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#171717">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#171717">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page-title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- FONTAWESOME -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css" integrity="sha256-PF6MatZtiJ8/c9O9HQ8uSUXr++R9KBYu4gbNG5511WE=" crossorigin="anonymous"> -->
    <!-- BOOTSTRAP CSS -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha256-YLGeXaapI0/5IgZopewRJcFXomhRMlYYjugPLSyNjTY=" crossorigin="anonymous"> -->

    <!-- Styles -->
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">

    <!-- ADD JS CLASS -->
    <script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
</head>
<body>

        <div id="app">
            @include('flash::message')
            <div class="alert" role="alert">
            A simple primary alert—check it out!
            </div>
            <app user="{{ Auth::user() }}" is-subscribed="{{ Auth::user()->subscribed('product_three') }}" trial-time-left="{{ Auth::user()->trialTimeLeft() }}" gravatar="{{ Auth::user()->gravatar }}"></app>
        </div>

    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
