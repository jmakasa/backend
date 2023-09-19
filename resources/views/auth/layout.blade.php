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
    <!-- <script src="{{ asset('public/js/ckeditor/ckeditor.js') }}"></script> -->
    <script src="{{ asset('public/libs/jquery/jquery.min.js') }}"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <script src="{{ asset('public/libs/easyui/jquery.easyui.min.js') }}"></script>
    <script src="{{ asset('public/libs/easyui/extension/datagrid-dnd.js') }}"></script>
    <script src="{{ asset('public/libs/easyui/locale/easyui-lang-en.js') }}"></script>
    <script src="{{ asset('public/libs/easyui/extension/datagrid-scrollview.js') }}"></script>
    <script src="{{ asset('public/libs/easyui/extension/datagrid-groupview.js') }}"></script>
    <script src="{{ asset('public/libs/summernote/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('public/libs/summernote/lang/summernote-zh-TW.min.js') }}"></script>
    <script src="{{ asset('public/libs/summernote/summernote-image-attributes.js?v=1') }}"></script>
    <script src="{{ asset('public/libs/summernote/summernote-image-attributes-en-us.js') }}"></script>
    <script src="{{ asset('../../../../../marketing/js/const.js') }}"></script>



    <!-- angularJs -->
    <script src="{{ asset('public/libs/angularJs-1.8.2/angular.min.js') }}"></script>
    <script src="{{ asset('public/libs/angularJs-1.8.2/angular-animate.min.js') }}"></script>
    <script src="{{ asset('public/libs/angularJs-1.8.2/ui-bootstrap-tpls-2.5.0.min.js') }}"></script>
    <script src="{{ asset('public/libs/angularJs-1.8.2/src/app.js') }}"></script>
    <script src="{{ asset('public/libs/angularJs-1.8.2/src/factory/dataFactory.js') }}"></script>
    <script src="{{ asset('public/libs/angularJs-1.8.2/src/factory/authFactory.js') }}"></script>
    @stack('extra-js')

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('public/libs/easyui/themes/metro-orange/easyui.css') }}" rel="stylesheet">
    <link href="{{ asset('public/libs/easyui/themes/icon.css') }}" rel="stylesheet">
    <link href="{{ asset('public/css/common.css?v=1') }}" rel="stylesheet">
    <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/libs/bootstrap-icons/font/bootstrap-icons.css') }}">
    <link href="{{ asset('public/libs/summernote/summernote-lite.min.css') }}" rel="stylesheet">

    @stack('extra-css')
</head>

<body>
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
