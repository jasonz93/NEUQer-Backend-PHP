<!DOCTYPE html>
<html>
<header>
    <meta charset="UTF-8" />
    <title>NEUQer公众平台——@yield('title')</title>
    @yield('stylesheets')
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('semantic/semantic.min.css') }}" />
    <style>
        .main.container {
            padding-top: 2em;
        }
    </style>
</header>
<body>
@include('wx3rd.manage.sidebar')
<div class="pusher">
    <div class="ui main container">
        @yield('body')
    </div>
</div>
<script src="{{ asset('jquery/jquery-2.2.2.js') }}" type="text/javascript"></script>
<script src="{{ asset('semantic/semantic.min.js') }}" type="text/javascript"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    });
</script>
@yield('javascripts')
</body>
</html>