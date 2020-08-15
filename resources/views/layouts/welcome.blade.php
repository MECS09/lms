<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name','LMS')}}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Bootstrap -->

        <link rel="stylesheet" href="/css/app.css">
        

    </head>
    <body>
        @include('inc.navbar')
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>