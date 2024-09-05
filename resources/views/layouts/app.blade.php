<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="_token" content="{{ csrf_token() }}">
    <title>
        @yield('title') - Anjali Chemicals System
    </title>
    <!-- Favicon -->
    <link href="{{ asset('assets/img/brand/favicon.png') }}" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="{{ asset('assets/js/plugins/nucleo/css/nucleo.css') }}" rel="stylesheet" />
    <link href=" {{ asset('assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="{{ asset('assets/css/argon-dashboard.css?v=1.1.2') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/daterangepicker/daterangepicker.css') }}" />
    <!-- Slick Slider -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/slick/slick.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/slick/slick-theme.css') }}" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

    <script src="{{ asset('assets/js/plugins/jquery/dist/jquery.min.js') }}"></script>
    <link href="{{ asset('assets/select2-4.0.0/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/select2-4.0.0/css/select2-bootstrap4.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/select2-4.0.0/js/select2.min.js') }}"></script>
    {{-- <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css"> --}}
    {{-- <script src="http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script> --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.12/js/select2.min.js" integrity="sha512-5+FrEmSijjxRArJWeLcCIEgoQYAgU0gSa9MgNMN+tVSS+MPZsEk9a7OkPZr7AzjNJng1Kl+tXOQVtJcsU+Ax0w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

    @yield('summernote_css')
</head>

@php
use Carbon\Carbon;
@endphp

{{-- <body> --}}
@if (App::environment('local'))
    <body>
@elseif (App::environment('production'))
    <body oncontextmenu="return false">
@endif
    @if (Auth::check())
        @include('layouts.partials.sidebar')
    @endif

    <div class="main-content" id="panel">
        <!-- Navbar -->
        @if (Auth::check())
            @include('layouts.partials.navbar')
        @endif

        <!-- End Navbar -->

        <div class="header bg-gradient-primary pb-4 pt-5 pt-md-7">
            <div class="container-fluid">
                <div class="header-body">
                    {{-- Add if condition if( route is admin/dashboard then show header-cards else none) --}}
                    @if (Route::is('home') && Auth::check())
                        @include('layouts.partials.dashboard-header-cards')
                    @endif
                </div>
            </div>
        </div>

        <div class="container-fluid mt-4">
            @yield('content')
            <!-- Footer -->
            @if (Auth::check())
                @include('layouts.partials.footer')
            @endif

        </div>
    </div>
    @if (App::environment('production'))
        <script type="text/javascript"> 
            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                alert("Use CTRL + C to Copy text and CTRL + V to Paste text.")
            });
            document.onkeydown = function(e) {
                if(event.keyCode == 123) {
                    return false;
                }
                if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
                    return false;
                }
                if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
                    return false;
                }
                if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
                    return false;
                }
                if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
                    return false;
                }
            }
        </script>
    @endif

    <!--   Core   -->
    <script type="text/javascript" src="{{ asset('assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!--   Optional JS   -->
    <script type="text/javascript" src="{{ asset('assets/js/plugins/chart.js/dist/Chart.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/plugins/chart.js/dist/Chart.extension.js') }}"></script>
    <!--   Argon JS   -->
    <script type="text/javascript" src="{{ asset('assets/js/argon-dashboard.min.js?v=1.1.2') }}"></script>
    <!-- Daterange Picker JS -->
    <script type="text/javascript" src="{{ asset('assets/daterangepicker/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Slick Slider -->
    <script type="text/javascript" src="{{ asset('assets/timepicker/jquery.timepicker.min.js') }}"></script>

    {{-- AutoScroll JS --}}
    <script type="text/javascript" src="{{ asset('js/AutoScroll.js') }}"></script>

    @yield('custom_scripts')

</body>

</html>
