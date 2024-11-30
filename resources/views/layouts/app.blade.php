<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="topbar_open">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Job Management</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" href="{{ asset('assets/img/admin/favicon.ico') }}" type="image/x-icon"/>

    <!-- Fonts and icons -->
    <script src="{{ asset('assets/plugins/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
            families: [
                "Font Awesome 5 Solid",
                "Font Awesome 5 Regular",
                "Font Awesome 5 Brands",
                "simple-line-icons",
            ],
            urls: ["{{ asset('assets/css/fonts.min.css') }}"],
            },
            active: function () {
            sessionStorage.fonts = true;
            },
        });
        var assetImg = '{{ asset("assets/img") }}';
    </script>

    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-select/1.13.14/css/bootstrap-select.min.css')}}">
    <!-- CSS Files -->
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    @yield('styles')
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
</head>

<body>
    @yield('content_app')
    <!--   Core JS Files   -->
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-select/v1.14.0-beta2/bootstrap-select.js')}}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ asset('assets/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <!-- Admin JS -->
    <script src="{{ asset('assets/js/admin.min.js') }}"></script>
    <script type="text/javascript">
        var url = "{{ url('notification/notificationNewList') }}",
            target = '#notification';
        @if(Auth::user())
            getData(url, target, {}, true, '#non');
        @endif
        $("#notifDropdown").click(function (e) {
            if($(this).hasClass("show")){
                getData(url, target, {}, true, '#non');
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
