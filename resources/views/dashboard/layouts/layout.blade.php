<!--
 * CoreUI - Open Source Bootstrap Admin Template
 * @version v1.0.0-alpha.2
 * @link http://coreui.io
 * Copyright (c) 2016 creativeLabs Łukasz Holeczek
 * @license MIT
 -->
<!DOCTYPE html>
<html lang="IR-fa" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ $settings->translate(app()->getlocale())->content }}">
    <meta name="keyword" content="{{ $settings->translate(app()->getlocale())->title }}">
    <link rel="shortcut icon" href="{{ asset('public/' . $settings->favicon) }}">
    <title>{{ $settings->translate(app()->getlocale())->title }}</title>
    <!-- <link rel="shortcut icon" href="assets/ico/favicon.png"> -->
    <title>CoreUI Bootstrap 4 Admin Template</title>
    <!-- Icons -->
    <link href="{{ asset('adminassets') }}/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('adminassets') }}/css/simple-line-icons.css" rel="stylesheet">
    <!-- Main styles for this application -->
    <link href="{{ asset('adminassets') }}/dest/style.css" rel="stylesheet">
    {{--  datatables css --}}
    @yield('css')
</head>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.0/classic/ckeditor.js"></script>


<body class="navbar-fixed sidebar-nav fixed-nav">
    <header class="navbar">
        <div class="container-fluid">
            <button class="navbar-toggler mobile-toggler hidden-lg-up" type="button">&#9776;</button>
            <a class="navbar-brand" href="{{ route('website') }}"
                style="background-image: url({{ asset('public/' . $settings->logo) }});">
            </a>
            <ul class="nav navbar-nav hidden-md-down">
                <li class="nav-item">
                    <a class="nav-link navbar-toggler layout-toggler" href="#">&#9776;</a>
                </li>

            </ul>
            <ul class="nav navbar-nav pull-left hidden-md-down  m-5">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button"
                        aria-haspopup="true" aria-expanded="false">
                        @if (auth()->user())
                            <img src="{{ asset('public/' . auth()->user()->profile) }}" class="img-avatar">
                        @endif

                        <span class="hidden-md-down"style="border-left: 2px black solid">
                            @if (auth()->user())
                                {{ auth()->user()->name }}
                            @else
                                not login
                            @endif
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @if (auth()->user())
                            <a class="dropdown-item" href="{{ route('dashboard.users.edit', auth()->user()->id) }}">
                        @endif <i class="fa fa-user"></i> پروفایل</a>
                        <div class="divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"><i class="fa fa-lock"></i>
                            {{ __('words.logout') }}</a>
                    </div>
                </li>
                <li class="nav-item dropdown ">
                    <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="hidden-md-down">{{ LaravelLocalization::getCurrentLocaleNative() }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">

                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                {{ $properties['native'] }}
                            </a>
                        @endforeach

                    </div>
                </li>
            </ul>
        </div>
    </header>
    @include('dashboard.layouts.sidebar')
    <main class="main">
        @yield('body')
    </main>


    <footer class="footer">
        <span class="text-left">
            <a href="http://coreui.io">CoreUI</a> &copy; 2022 creativeLabs.
        </span>
        <span class="pull-right">
            Powered by <a href="http://coreui.io">KarimBoulad</a>
        </span>
    </footer>
    <!-- Bootstrap and necessary plugins -->
    <script src="{{ asset('adminassets') }}/js/libs/jquery.min.js"></script>
    <script src="{{ asset('adminassets') }}/js/libs/tether.min.js"></script>
    <script src="{{ asset('adminassets') }}/js/libs/bootstrap.min.js"></script>
    <script src="{{ asset('adminassets') }}/js/libs/pace.min.js"></script>

    <!-- Plugins and scripts required by all views -->
    <script src="{{ asset('adminassets') }}/js/libs/Chart.min.js"></script>

    <!-- CoreUI main scripts -->

    <script src="{{ asset('adminassets') }}/js/app.js"></script>

    <!-- Plugins and scripts required by this views -->
    <!-- Custom scripts required by this view -->
    <script src="{{ asset('adminassets') }}/js/views/main.js"></script>

    <!-- Grunt watch plugin -->
    {{-- <script src="{{ asset('adminassets') }}///localhost:35729/livereload.js"></script> --}}
    @yield('javascript')

    <script>
        var allEditors = document.querySelectorAll('#editor');
        for (var i = 0; i < allEditors.length; i++) {
            ClassicEditor.create(allEditors[i]);
        }

        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
</body>

</html>
