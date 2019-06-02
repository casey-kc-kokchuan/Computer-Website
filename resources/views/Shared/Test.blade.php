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
           <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
   


    </head>
    <body>


        <div class="wrapper">

            <nav id="sidebar">
                
                <div class="sidebar-header">
                </div>

                <ul class="list-unstyled components">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Product</a></li>
                    <li><a href="#">Account</a></li>
                </ul>

            </nav>

            <div id="main">
                <nav class="navbar navbar-expand-lg navbar-light bg- light">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="btn btn-info" onclick="toggleSidebar()">
                            <i class="fas fa-align-left"></i>
                            <span>Toggle Sidebar</span>
                        </button>

                    </div>

                </nav>

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et felis tortor. Nunc imperdiet velit id mi dignissim, vitae tristique ligula ornare. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus non blandit lacus, convallis sodales nulla. Suspendisse fringilla tortor felis, vitae semper turpis efficitur nec. Pellentesque porta velit sed cursus rutrum. Mauris aliquet sem faucibus libero fermentum maximus. Maecenas et tristique ante, at tempus turpis. Duis ultrices interdum dictum. Donec eleifend venenatis eros. Phasellus diam tortor, ornare sit amet risus sit amet, elementum dictum odio. Nam viverra nibh at pretium venenatis. Praesent ipsum dui, hendrerit id libero ac, facilisis tempor sapien. Aliquam at mi vitae mi commodo imperdiet. Maecenas a varius diam.</p>

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et felis tortor. Nunc imperdiet velit id mi dignissim, vitae tristique ligula ornare. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus non blandit lacus, convallis sodales nulla. Suspendisse fringilla tortor felis, vitae semper turpis efficitur nec. Pellentesque porta velit sed cursus rutrum. Mauris aliquet sem faucibus libero fermentum maximus. Maecenas et tristique ante, at tempus turpis. Duis ultrices interdum dictum. Donec eleifend venenatis eros. Phasellus diam tortor, ornare sit amet risus sit amet, elementum dictum odio. Nam viverra nibh at pretium venenatis. Praesent ipsum dui, hendrerit id libero ac, facilisis tempor sapien. Aliquam at mi vitae mi commodo imperdiet. Maecenas a varius diam.</p>

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et felis tortor. Nunc imperdiet velit id mi dignissim, vitae tristique ligula ornare. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus non blandit lacus, convallis sodales nulla. Suspendisse fringilla tortor felis, vitae semper turpis efficitur nec. Pellentesque porta velit sed cursus rutrum. Mauris aliquet sem faucibus libero fermentum maximus. Maecenas et tristique ante, at tempus turpis. Duis ultrices interdum dictum. Donec eleifend venenatis eros. Phasellus diam tortor, ornare sit amet risus sit amet, elementum dictum odio. Nam viverra nibh at pretium venenatis. Praesent ipsum dui, hendrerit id libero ac, facilisis tempor sapien. Aliquam at mi vitae mi commodo imperdiet. Maecenas a varius diam.</p>

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et felis tortor. Nunc imperdiet velit id mi dignissim, vitae tristique ligula ornare. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus non blandit lacus, convallis sodales nulla. Suspendisse fringilla tortor felis, vitae semper turpis efficitur nec. Pellentesque porta velit sed cursus rutrum. Mauris aliquet sem faucibus libero fermentum maximus. Maecenas et tristique ante, at tempus turpis. Duis ultrices interdum dictum. Donec eleifend venenatis eros. Phasellus diam tortor, ornare sit amet risus sit amet, elementum dictum odio. Nam viverra nibh at pretium venenatis. Praesent ipsum dui, hendrerit id libero ac, facilisis tempor sapien. Aliquam at mi vitae mi commodo imperdiet. Maecenas a varius diam.</p>

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et felis tortor. Nunc imperdiet velit id mi dignissim, vitae tristique ligula ornare. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus non blandit lacus, convallis sodales nulla. Suspendisse fringilla tortor felis, vitae semper turpis efficitur nec. Pellentesque porta velit sed cursus rutrum. Mauris aliquet sem faucibus libero fermentum maximus. Maecenas et tristique ante, at tempus turpis. Duis ultrices interdum dictum. Donec eleifend venenatis eros. Phasellus diam tortor, ornare sit amet risus sit amet, elementum dictum odio. Nam viverra nibh at pretium venenatis. Praesent ipsum dui, hendrerit id libero ac, facilisis tempor sapien. Aliquam at mi vitae mi commodo imperdiet. Maecenas a varius diam.</p>

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et felis tortor. Nunc imperdiet velit id mi dignissim, vitae tristique ligula ornare. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus non blandit lacus, convallis sodales nulla. Suspendisse fringilla tortor felis, vitae semper turpis efficitur nec. Pellentesque porta velit sed cursus rutrum. Mauris aliquet sem faucibus libero fermentum maximus. Maecenas et tristique ante, at tempus turpis. Duis ultrices interdum dictum. Donec eleifend venenatis eros. Phasellus diam tortor, ornare sit amet risus sit amet, elementum dictum odio. Nam viverra nibh at pretium venenatis. Praesent ipsum dui, hendrerit id libero ac, facilisis tempor sapien. Aliquam at mi vitae mi commodo imperdiet. Maecenas a varius diam.</p>

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et felis tortor. Nunc imperdiet velit id mi dignissim, vitae tristique ligula ornare. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus non blandit lacus, convallis sodales nulla. Suspendisse fringilla tortor felis, vitae semper turpis efficitur nec. Pellentesque porta velit sed cursus rutrum. Mauris aliquet sem faucibus libero fermentum maximus. Maecenas et tristique ante, at tempus turpis. Duis ultrices interdum dictum. Donec eleifend venenatis eros. Phasellus diam tortor, ornare sit amet risus sit amet, elementum dictum odio. Nam viverra nibh at pretium venenatis. Praesent ipsum dui, hendrerit id libero ac, facilisis tempor sapien. Aliquam at mi vitae mi commodo imperdiet. Maecenas a varius diam.</p>

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et felis tortor. Nunc imperdiet velit id mi dignissim, vitae tristique ligula ornare. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus non blandit lacus, convallis sodales nulla. Suspendisse fringilla tortor felis, vitae semper turpis efficitur nec. Pellentesque porta velit sed cursus rutrum. Mauris aliquet sem faucibus libero fermentum maximus. Maecenas et tristique ante, at tempus turpis. Duis ultrices interdum dictum. Donec eleifend venenatis eros. Phasellus diam tortor, ornare sit amet risus sit amet, elementum dictum odio. Nam viverra nibh at pretium venenatis. Praesent ipsum dui, hendrerit id libero ac, facilisis tempor sapien. Aliquam at mi vitae mi commodo imperdiet. Maecenas a varius diam.</p>

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et felis tortor. Nunc imperdiet velit id mi dignissim, vitae tristique ligula ornare. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus non blandit lacus, convallis sodales nulla. Suspendisse fringilla tortor felis, vitae semper turpis efficitur nec. Pellentesque porta velit sed cursus rutrum. Mauris aliquet sem faucibus libero fermentum maximus. Maecenas et tristique ante, at tempus turpis. Duis ultrices interdum dictum. Donec eleifend venenatis eros. Phasellus diam tortor, ornare sit amet risus sit amet, elementum dictum odio. Nam viverra nibh at pretium venenatis. Praesent ipsum dui, hendrerit id libero ac, facilisis tempor sapien. Aliquam at mi vitae mi commodo imperdiet. Maecenas a varius diam.</p>

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et felis tortor. Nunc imperdiet velit id mi dignissim, vitae tristique ligula ornare. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus non blandit lacus, convallis sodales nulla. Suspendisse fringilla tortor felis, vitae semper turpis efficitur nec. Pellentesque porta velit sed cursus rutrum. Mauris aliquet sem faucibus libero fermentum maximus. Maecenas et tristique ante, at tempus turpis. Duis ultrices interdum dictum. Donec eleifend venenatis eros. Phasellus diam tortor, ornare sit amet risus sit amet, elementum dictum odio. Nam viverra nibh at pretium venenatis. Praesent ipsum dui, hendrerit id libero ac, facilisis tempor sapien. Aliquam at mi vitae mi commodo imperdiet. Maecenas a varius diam.</p>

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et felis tortor. Nunc imperdiet velit id mi dignissim, vitae tristique ligula ornare. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus non blandit lacus, convallis sodales nulla. Suspendisse fringilla tortor felis, vitae semper turpis efficitur nec. Pellentesque porta velit sed cursus rutrum. Mauris aliquet sem faucibus libero fermentum maximus. Maecenas et tristique ante, at tempus turpis. Duis ultrices interdum dictum. Donec eleifend venenatis eros. Phasellus diam tortor, ornare sit amet risus sit amet, elementum dictum odio. Nam viverra nibh at pretium venenatis. Praesent ipsum dui, hendrerit id libero ac, facilisis tempor sapien. Aliquam at mi vitae mi commodo imperdiet. Maecenas a varius diam.</p>

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et felis tortor. Nunc imperdiet velit id mi dignissim, vitae tristique ligula ornare. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus non blandit lacus, convallis sodales nulla. Suspendisse fringilla tortor felis, vitae semper turpis efficitur nec. Pellentesque porta velit sed cursus rutrum. Mauris aliquet sem faucibus libero fermentum maximus. Maecenas et tristique ante, at tempus turpis. Duis ultrices interdum dictum. Donec eleifend venenatis eros. Phasellus diam tortor, ornare sit amet risus sit amet, elementum dictum odio. Nam viverra nibh at pretium venenatis. Praesent ipsum dui, hendrerit id libero ac, facilisis tempor sapien. Aliquam at mi vitae mi commodo imperdiet. Maecenas a varius diam.</p>
            </div>

            
        </div>
 
    <script type="text/javascript">
        $(document).ready(function () {
            $("#sidebar").mCustomScrollbar({
                 theme: "minimal"
            });
            
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $('#main').toggleClass('active');
            });

        });

    </script>
    </body>
</html>
