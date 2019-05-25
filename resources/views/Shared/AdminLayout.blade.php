<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" type="text/css"  href="{{ URL::asset('css/app.css') }}">

        <title>@yield('title','Provide Title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">



        <link rel="stylesheet" type="text/css"  href="{{ URL::asset('css/app.css') }}">
        <link rel="stylesheet" type="text/css"  href="{{ URL::asset('css/all.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/RWD_max991.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/RWD_min992.css')}}">
        <script src="{{ URL::asset('js/app.js')}}"></script>
        <script src="{{ URL::asset('js/utility.js')}}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
{{--         <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> --}}
        @yield('head')


    </head>
    <body>


       @yield('body')

       @yield('script')
    </body>
</html>
