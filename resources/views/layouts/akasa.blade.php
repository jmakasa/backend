<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __("general.frontend.title") }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- angularJs -->
    <script src="{{ asset('js/angularJs-1.8.2/angular.min.js') }}"></script>
    <script src="{{ asset('js/angularJs-1.8.2/src/app.js') }}"></script>
    <script src="{{ asset('js/angularJs-1.8.2/src/factory/dataFactory.js') }}"></script>
    <!-- Styles -->
    <link href="{{ asset('css/slick/slick-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/modern-business.css') }}" rel="stylesheet">
    <link href="{{ asset('css/product_list.css') }}" rel="stylesheet">
    <link href="{{ asset('css/prod.css') }}" rel="stylesheet">

</head>

<body>
    <!--navbar-->
    <div class="navbar_box">
        <nav class="navbar navbar-expand-md navbar-light bg-wh">
            <div class="container custom-container-width">
                <a class="navbar-brand" href="{{ route('home.landing',app()->getLocale()) }}"><img src="{{ asset('img/akasa_logo.svg') }}" width="116" height="28" class="d-inline-block align-top" alt="akasa-logo"></a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        @foreach ($category as $cat)
                        <li class="nav-item dropdown {{($cat->spec_css == 'dark') ? ' blue' : ''}}">
                            <a class="nav-link" href="#" id="navbarDropdown" data-bs-toggle="dropdown">{{Str::upper($cat->name[app()->getLocale()])}}</a>
                            <div class="dropdown-menu rounded-0 {{($cat->spec_css == 'dark') ? ' dropdown-menu-dark' : ''}}" aria-labelledby="navbarDropdown">
                                <div class="container">
                                    <div class="row">
                                        @if ($cat->children)
                                        @foreach ($cat->children as $children)
                                        <div class="col-md-2">
                                            <a class="header_categorytitle dropdown-item" href="product.list.cpucooler.html">{!! Str::upper($children->name[app()->getLocale()]) !!}</a>
                                            @foreach ($children->children as $child)
                                            <a class="dropdown-item border-start ms-3" href="product.list.cpucooler.html">{{$child->name[app()->getLocale()]}}</a>
                                            @endforeach
                                        </div>
                                        @if ($cat->img && $loop->last)
                                        <div class="col-md-4">
                                            <img src="{{URL::asset($cat->img)}}" width="431" height="287" class="d-block img-fluid" alt="...">
                                        </div>
                                        @endif
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>

                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">BUSINESS</a>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <input class="form-control form-control-sm ms-3 rounded-pill" type="search" placeholder="Search" aria-label="Search">
                    </form>
                </div>
            </div>
        </nav>
    </div>
    <main class="py-4">
        @yield('content')
    </main>
    </div>
    @include('layouts.akasa_footer')
    <script src="{{ asset('js/jquery-3.4.1.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.slick/1.5.9/slick.min.js"></script>


    <!--rwdImageMaps======================================================================================-->
    <script src="{{ asset('js/jquery.rwdImageMaps.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>