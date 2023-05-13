<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title> @yield('title', $settings->translate(app()->getlocale())->title)</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" , content="@yield('meta_description', $settings->content)">
    <link rel="shortcut icon" href="{{ asset('public/' . $settings->favicon) }}">
    <meta name="keywords" , content="@yield('meta_keywords', $settings->title)">
    <!-- Favicon -->
    <link href="{{ asset($settings->favicon) }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('front') }}/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('front') }}/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row align-items-center bg-light px-lg-5">
            <div class="col-12 col-md-8">
                <div class="d-flex justify-content-between">
                    <div class="bg-primary text-white text-center py-2" style="width: 100px;">Tranding</div>
                    <div class="owl-carousel owl-carousel-1 tranding-carousel position-relative d-inline-flex align-items-center ml-3"
                        style="width: calc(100% - 100px); padding-left: 90px;">
                        @foreach ($lastFivePosts as $post)
                            <div class="text-truncate"><a class="text-secondary"
                                    href="{{ Route('post', $post->id) }}">{{ $post->title }}</a></div>
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="col-md-4 text-right d-none d-md-block">
                {{ Date('D Y,M,d') }}
            </div>
        </div>
        <div class="row align-items-center py-2 px-lg-5">
            <div class="col-lg-4">
                <a href="{{route('login')}}" class="navbar-brand d-none d-lg-block">
                    <img src="{{ asset('public/' . $settings->logo) }}" alt="" style="height: 70px">
                </a>
            </div>
            <div class="col-lg-8 text-center text-lg-right">
                <a href="{{route('login')}}">
                <img class="img-fluid" src="{{ asset('public/' . $settings->logo) }}" alt=""
                    style="height: 70px"></a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <div class="container-fluid p-0 mb-3">
        <nav class="navbar navbar-expand-lg bg-light navbar-light py-2 py-lg-0 px-lg-5">
            <a href="" class="navbar-brand d-block d-lg-none">
                <h1 class="m-0 display-5 text-uppercase"><span class="text-primary">News</span>Room</h1>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between px-0 px-lg-3" id="navbarCollapse">
                <div class="navbar-nav mr-auto py-0">
                    <a href="{{ route('website') }}" class="nav-item nav-link active">{{ __('words.home') }}</a>
                    @foreach ($categories as $category)
                        <div class="nav-item dropdown">
                            <a @if (count($category->children) == 0) href="" @else href='#' @endif
                                class="nav-link  @if (count($category->children) > 0) dropdown-toggle @endif"
                                @if (count($category->children) > 0) data-toggle="dropdown" @endif>{{ $category->title }}</a>
                            @if (count($category->children) > 0)
                                <div class="dropdown-menu rounded-0 m-0">
                                    @foreach ($category->children as $child)
                                        <a href="" class="dropdown-item">{{ $child->title }}</a>
                                    @endforeach


                                </div>
                            @endif
                        </div>
                    @endforeach







                </div>


                <li class="nav-item dropdown">
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
            </div>
        </nav>
    </div>
    <!-- Navbar End -->
    @yield('body')
    <!-- Footer Start -->
    <div class="container-fluid bg-light pt-5 px-sm-3 px-md-5">
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-5">
                <a href="{{route('login')}}" class="navbar-brand">

                    <img src="{{ asset('public/' . $settings->logo) }}" alt="" style="height: 70px">
                </a>
                <p>{{ $settings->translate(app()->getlocale())->content }}</p>
                <div class="d-flex justify-content-start mt-4">

                    @if ($settings->facebook != '')
                        <a class="btn btn-outline-secondary text-center mr-2 px-0" target="_blank"
                            style="width: 38px; height: 38px;" href="{{ $settings->facebook }}"><i
                                class="fab fa-facebook-f"></i></a>
                    @endif
                    @if ($settings->instagram != '')
                        <a target="_blank" class="btn btn-outline-secondary text-center mr-2 px-0"
                            style="width: 38px; height: 38px;" href="{{ $settings->instagram }}"><i
                                class="fab fa-instagram"></i></a>
                    @endif
                </div>
            </div>
            <div class="col-lg-6 col-md-6 mb-5">
                <h4 class="font-weight-bold mb-4">{{ __('words.categories') }}</h4>
                <div class="d-flex flex-wrap m-n1">
                    @foreach ($categories as $category)
                        <div class="nav-item dropdown">
                            <a @if (count($category->children) == 0) href="{{ Route('category', $category->id) }}" @else href='#' @endif
                                class="nav-link  @if (count($category->children) > 0) dropdown-toggle @endif"
                                @if (count($category->children) > 0) data-toggle="dropdown" @endif>{{ $category->title }}</a>
                            @if (count($category->children) > 0)
                                <div class="dropdown-menu rounded-0 m-0">
                                    @foreach ($category->children as $child)
                                        <a href="{{ Route('category', $child->id) }}"
                                            class="dropdown-item">{{ $child->title }}</a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4 px-sm-3 px-md-5">
      <p class="m-0 text-center">
        &copy; <a class="font-weight-bold" href="#">the world now</a>. جميع الحقوق محفوظة.

        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
        Designed by <a class="font-weight-bold" href="#">karimBoulad</a>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-dark back-to-top"><i class="fa fa-angle-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('front') }}/lib/easing/easing.min.js"></script>
    <script src="{{ asset('front') }}/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="{{ asset('front') }}/mail/jqBootstrapValidation.min.js"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('front') }}/js/main.js"></script>
</body>

</html>
