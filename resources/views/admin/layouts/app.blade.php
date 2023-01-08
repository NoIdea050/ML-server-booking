<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>



    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('all/admin/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <script src="https://kit.fontawesome.com/6bb7ec511f.js" crossorigin="anonymous"></script>
    <link href="{{ asset('all/admin/assets/css/plugins.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('all/admin/assets/css/pageheading.css')}}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    {{-- tostr Alert --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    @yield('header-links')
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

</head>

<body class="sidebar-noneoverflow" data-spy="scroll" data-target="#navSection" data-offset="100">

    <!--  BEGIN NAVBAR  -->
    @include('admin.layouts.navbar')
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        @include('admin.layouts.sidebar')
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        @yield('contents')
        <!--  END CONTENT AREA  -->


    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->

    <script src="{{ asset('all/admin/bootstrap/js/popper.min.js')}}"></script>
    <script src="{{ asset('all/admin/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('all/admin/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{ asset('all/admin/assets/js/app.js')}}"></script>
    <script>
    $(document).ready(function() {
        App.init();
    });
    </script>
    <script src="{{ asset('all/admin/assets/js/custom.js')}}"></script>
    <script src="{{ asset('all/admin/plugins/highlight/highlight.pack.js') }}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    @yield('footer-links')
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->



    {{-- tostr alert --}}
    <script>
    @if(Session::has('success'))
    toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.success("{{ session('success') }}");
    @endif

    @if(Session::has('error'))
    toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.error("{{ session('error') }}");
    @endif

    @if(Session::has('info'))
    toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.info("{{ session('info') }}");
    @endif

    @if(Session::has('warning'))
    toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.warning("{{ session('warning') }}");
    @endif

    @if(count($errors) > 0)
    @foreach($errors -> all() as $error)
    toastr.options = {
        "closeButton": true,
        "progressBar": true
    }
    toastr.warning("{{ $error }}");
    @endforeach
    @endif
    </script>

</body>

</html>