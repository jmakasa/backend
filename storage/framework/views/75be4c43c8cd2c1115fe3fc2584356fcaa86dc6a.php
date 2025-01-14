<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" ng-app="akasa-web">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'Laravel')); ?></title>
    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    <!-- library -->
    <script src="<?php echo e(asset('js/ckeditor/ckeditor.js')); ?>"></script>
    <script src="<?php echo e(asset('js/easyui-1.10.2/jquery.easyui.min.js')); ?>"></script>
    <!-- angularJs -->
    <script src="<?php echo e(asset('js/angularJs-1.8.2/angular.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/angularJs-1.8.2/src/app.js')); ?>"></script>
    <script src="<?php echo e(asset('js/angularJs-1.8.2/src/factory/dataFactory.js')); ?>"></script>
    <script src="<?php echo e(asset('js/angularJs-1.8.2/src/ctrl/ProductCtrl.js')); ?>"></script>

    

    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('js/easyui-1.10.2/themes/default/easyui.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('js/easyui-1.10.2/themes/icon.css')); ?>" rel="stylesheet">
</head>

<body>


    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="<?php echo e(route('admin.dashboard',app()->getLocale())); ?>">
                    <?php echo e(config('app.name', 'Laravel')); ?> - admin <?php echo e(env('DOCDIR')); ?>

                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="<?php echo e(__('Toggle navigation')); ?>">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        <?php if(auth()->guard()->guest()): ?>
                        <?php if(Route::has('login')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>
                        </li>
                        <?php endif; ?>
                        <!--
                            <?php if(Route::has('register')): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo e(route('register')); ?>"><?php echo e(__('Register')); ?></a>
                                </li>
                            <?php endif; ?>
-->
                        <?php else: ?>
                        <!-- Products -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <?php echo e(__('general.products.products')); ?>

                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="<?php echo e(route('admin.products_list',app()->getLocale())); ?>">
                                    <?php echo e(__('general.products.products')); ?>

                                </a>
                                <a class="dropdown-item" href="<?php echo e(route('admin.products_create',app()->getLocale())); ?>">
                                    <?php echo e(__('general.add')); ?> <?php echo e(__('general.products.name')); ?>

                                </a>
                            </div>

                        </li> <!-- END Products -->
                        <!-- Tags -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <?php echo e(__('general.tags.name')); ?>

                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="<?php echo e(route('admin.tags_list',app()->getLocale())); ?>">
                                    <?php echo e(__('general.tags.tags')); ?>

                                </a>
                                <a class="dropdown-item" href="<?php echo e(route('admin.tags_create',app()->getLocale())); ?>">
                                    <?php echo e(__('general.add')); ?> <?php echo e(__('general.tags.name')); ?>

                                </a>
                            </div>

                        </li> <!-- END Tags -->
                        <!-- Keywords -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <?php echo e(__('general.keywords.keywords')); ?>

                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="<?php echo e(route('admin.keywords_list',app()->getLocale())); ?>">
                                    <?php echo e(__('general.keywords.name')); ?>

                                </a>
                                <a class="dropdown-item" href="<?php echo e(route('admin.keywords_create',app()->getLocale())); ?>">
                                    <?php echo e(__('general.add')); ?> <?php echo e(__('general.keywords.name')); ?>

                                </a>
                            </div>

                        </li> <!-- END Keywords -->
                        <!-- Category -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <?php echo e(__('general.category.category')); ?>

                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="<?php echo e(route('admin.category_list',app()->getLocale())); ?>">
                                    <?php echo e(__('general.category.list')); ?>

                                </a>
                                <a class="dropdown-item" href="<?php echo e(route('admin.category_create',app()->getLocale())); ?>">
                                    <?php echo e(__('general.add')); ?> <?php echo e(__('general.category.category')); ?>

                                </a>
                            </div>

                        </li> <!-- END Category -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <?php echo e(Auth::user()->name); ?>

                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();  document.getElementById('logout-form').submit();">
                                    <?php echo e(__('Logout')); ?>

                                </a>

                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                    <?php echo csrf_field(); ?>
                                </form>
                            </div>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

</body>

</html><?php /**PATH /akasa/www/backend/resources/views/layouts/admin.blade.php ENDPATH**/ ?>