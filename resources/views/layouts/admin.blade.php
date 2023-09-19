<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" ng-app="akasa-web">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('public/js/app.js') }}"></script>
    <!-- library -->
    <script src="{{ asset('public/js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/libs/easyui/jquery.easyui.min.js') }}"></script>
    <script src="{{ asset('public/libs/easyui/jquery.easyui.min.js') }}"></script>
    <script src="{{ asset('public/libs/easyui/extension/datagrid-dnd.js') }}"></script>
    <script src="{{ asset('public/libs/easyui/locale/easyui-lang-en.js') }}"></script>
    <script src="{{ asset('public/libs/easyui/extension/datagrid-scrollview.js') }}"></script>
    <script src="{{ asset('public/libs/easyui/extension/datagrid-groupview.js') }}"></script>
    <script src="{{ asset('public/libs/summernote/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('public/libs/summernote/lang/summernote-zh-TW.min.js') }}"></script>
    <script src="{{ asset('public/libs/summernote/summernote-image-attributes.js?v=1') }}"></script>
    <script src="{{ asset('public/libs/summernote/summernote-image-attributes-en-us.js') }}"></script>
    <!-- angularJs -->
    <script src="{{ asset('public/libs/angularJs-1.8.2/angular.min.js') }}"></script>
    <script src="{{ asset('public/libs/angularJs-1.8.2/src/app.js') }}"></script>
    <script src="{{ asset('public/libs/angularJs-1.8.2/src/factory/dataFactory.js') }}"></script>
    @stack('extra-js')

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('public/libs/easyui/themes/default/easyui.css') }}" rel="stylesheet">
    <link href="{{ asset('public/libs/easyui/themes/icon.css') }}" rel="stylesheet">

    @stack('extra-css')
</head>

<body>


    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('admin.dashboard',app()->getLocale()) }}">
                    {{ config('app.name', 'Laravel') }} - admin
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif
                        <!--
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
-->
                        @else
                        <!-- Employees -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ __('general.employees.employee') }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('admin.employees.viewList',app()->getLocale()) }}">
                                    {{ __('general.employees.view_list') }}
                                </a>
                            </div>

                        </li> <!-- END Products -->
                        <!-- Products -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ __('general.products.products') }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('admin.products_list',app()->getLocale()) }}">
                                    {{ __('general.products.products') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('admin.products_create',app()->getLocale()) }}">
                                    {{ __('general.add') }} {{ __('general.products.name') }}
                                </a>
                            </div>

                        </li> <!-- END Products -->
                        <!-- Tags -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ __('general.tags.name') }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('admin.tags_list',app()->getLocale()) }}">
                                    {{ __('general.tags.tags') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('admin.tags_create',app()->getLocale()) }}">
                                    {{ __('general.add') }} {{ __('general.tags.name') }}
                                </a>
                            </div>

                        </li> <!-- END Tags -->
                        <!-- Keywords -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ __('general.keywords.keywords') }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('admin.keywords_list',app()->getLocale()) }}">
                                    {{ __('general.keywords.name') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('admin.keywords_create',app()->getLocale()) }}">
                                    {{ __('general.add') }} {{ __('general.keywords.name') }}
                                </a>
                            </div>

                        </li> <!-- END Keywords -->
                        <!-- Category -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ __('general.category.category') }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('admin.category_list',app()->getLocale()) }}">
                                    {{ __('general.category.list') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('admin.category_create',app()->getLocale()) }}">
                                    {{ __('general.add') }} {{ __('general.category.category') }}
                                </a>
                            </div>

                        </li> <!-- END Category -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();  document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

</body>

</html>