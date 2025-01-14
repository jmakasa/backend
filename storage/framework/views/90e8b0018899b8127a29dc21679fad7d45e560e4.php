<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(__("general.frontend.title")); ?></title>
    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>

    <!-- angularJs -->
    <script src="<?php echo e(asset('js/angularJs-1.8.2/angular.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/angularJs-1.8.2/src/app.js')); ?>"></script>
    <script src="<?php echo e(asset('js/angularJs-1.8.2/src/factory/dataFactory.js')); ?>"></script>
    <!-- Styles -->
    <link href="<?php echo e(asset('css/slick/slick-theme.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/modern-business.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/product_list.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/prod.css')); ?>" rel="stylesheet">

</head>

<body>
    <!--navbar-->
    <div class="navbar_box">
        <nav class="navbar navbar-expand-md navbar-light bg-wh">
            <div class="container custom-container-width">
                <a class="navbar-brand" href="<?php echo e(route('home.landing',app()->getLocale())); ?>"><img src="<?php echo e(asset('img/akasa_logo.svg')); ?>" width="116" height="28" class="d-inline-block align-top" alt="akasa-logo"></a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="nav-item dropdown <?php echo e(($cat->spec_css == 'dark') ? ' blue' : ''); ?>">
                            <a class="nav-link" href="#" id="navbarDropdown" data-bs-toggle="dropdown"><?php echo e(Str::upper($cat->name[app()->getLocale()])); ?></a>
                            <div class="dropdown-menu rounded-0 <?php echo e(($cat->spec_css == 'dark') ? ' dropdown-menu-dark' : ''); ?>" aria-labelledby="navbarDropdown">
                                <div class="container">
                                    <div class="row">
                                        <?php if($cat->children): ?>
                                        <?php $__currentLoopData = $cat->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $children): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-md-2">
                                            <a class="header_categorytitle dropdown-item" href="product.list.cpucooler.html"><?php echo Str::upper($children->name[app()->getLocale()]); ?></a>
                                            <?php $__currentLoopData = $children->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a class="dropdown-item border-start ms-3" href="product.list.cpucooler.html"><?php echo e($child->name[app()->getLocale()]); ?></a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <?php if($cat->img && $loop->last): ?>
                                        <div class="col-md-4">
                                            <img src="<?php echo e(URL::asset($cat->img)); ?>" width="431" height="287" class="d-block img-fluid" alt="...">
                                        </div>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    </div>
    <?php echo $__env->make('layouts.akasa_footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="<?php echo e(asset('js/jquery-3.4.1.js')); ?>"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.slick/1.5.9/slick.min.js"></script>


    <!--rwdImageMaps======================================================================================-->
    <script src="<?php echo e(asset('js/jquery.rwdImageMaps.js')); ?>"></script>
    <script src="<?php echo e(asset('js/custom.js')); ?>"></script>
</body>
</html><?php /**PATH /akasa/www/backend/resources/views/layouts/akasa.blade.php ENDPATH**/ ?>