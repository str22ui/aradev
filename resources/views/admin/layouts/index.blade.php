@include('admin.layouts.partials.header')
{{-- Struktur main body untuk blade templating --}}
<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                @include('admin.layouts.partials.navigation')
            </div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <h3>{{ $page_heading }}</h3>
            </div>
            <div class="page-content">
                @yield('content')
            </div>
            @include('admin.layouts.partials.footer')
