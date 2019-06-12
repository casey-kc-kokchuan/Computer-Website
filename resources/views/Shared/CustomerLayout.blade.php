<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title','Provide Title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">


        <link rel="stylesheet" type="text/css"  href="{{ URL::asset('css/app.css') }}">
        <link rel="stylesheet" type="text/css"  href="{{ URL::asset('css/all.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/RWD_max991.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/RWD_992to1210.css')}}">
        <script src="{{ URL::asset('js/app.js')}}"></script>
        <script src="{{ URL::asset('js/utility.js')}}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

        @yield('head')

        <style type="text/css">
           
           html, body
           {
                height:100%;
           } 

        </style>

    </head>
    <body>

       @yield('body')
       

       @yield('script')
    </body>
</html>
