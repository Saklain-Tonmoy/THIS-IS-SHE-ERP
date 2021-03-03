<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')
</head>
<body class="bg-theme bg-theme1">
<!-- wrapper -->
    <div class="wrapper">
        <!-- sidebar -->
        @include('layouts.sidebar')
        <!-- navbar OR, header -->
        @include('layouts.navbar')
        <!-- page wrapper OR, page contents -->
        @yield('content')
        <!-- footer && overlay toggle-icon -->
        @include('layouts.footer')
    </div>

    <!-- theme switcher -->
    @include('layouts.theme_switcher')
    @include('layouts.script')
    
</body>
</html>