{{-- 
Layout: base 

  The base layout provides no structure on its own. Instead, other
  layouts should extend this layout according to their intended use.

Usage: @extend('layouts.base')
--}}
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', "Linux Car Wash")</title>

    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css">

    @yield('head')

  </head>

  <body>
    
    {{-- We need this main wrapped div so we can bind the root Vue to the app. This way the navbar gets 
    vue and the main body content doesnt get Vue. Every page extends base but not every 
    page extends layouts/app   --}}
    <div id="app">
      {{-- Provide a blank canvas for views and layouts that extend the main layout. --}}
      @yield('main')  
    </div>
    
    <script src="/js/app.js"></script>
    @yield("script")

  </body>
</html>
