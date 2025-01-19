<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="A responsive admin dashboard template with sidebar navigation.">
    <meta name="robots" content="index, follow">
    <title><?php echo $__env->yieldContent('title', ''); ?> <?php echo e($siteSetting->title ?? ''); ?></title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <link rel="shortcut icon" href="<?php echo e(asset('assets/img/siteLogo.png')); ?>">
</head>
<body>
<div id="toastContainer" class="toast-container"></div>
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #337ab7; color: white;">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Action</h5>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to <span id="actionType"></span> this <span id="entityType"></span>?</p>
            </div>
            <div class="modal-footer">
                <a href="<?php echo e(request()->url()); ?>" type="button" class="btn btn-secondary">Cancel</a>
                <button type="button" class="btn btn-primary" id="confirmAction" style="background-color: #337ab7;">Yes, Confirm</button>
            </div>
        </div>
    </div>
</div>
<?php if(session('success')): ?>
    <div class="toast-container">
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true"
             style="background-color: #d4edda; color: #155724;">
            <div class="toast-body text-dark">
                <button type="button" class="btn-close float-end d-flex justify-content-center"
                        data-bs-dismiss="toast" aria-label="Close"></button>
                <?php echo e(session('success')); ?>

            </div>
        </div>
    </div>
<?php endif; ?>
<?php if(session('validation_errors')): ?>
    <div class="toast-container">
        <?php $__currentLoopData = session('validation_errors'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    <button type="button" class="btn-close float-end d-flex justify-content-center"
                            data-bs-dismiss="toast" aria-label="Close"></button>
                    <?php echo e($error); ?>

                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>


<?php
    $profileImage = auth()->user() !== null && auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : asset('assets/img/profileImage.png');
?>


<?php if(auth()->user()): ?>
    <div class="main-container d-flex">
        <?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <main class="content">
            <nav class="navbar navbar-expand-md navbar-light bg-light top-bar" aria-label="Main navigation">
                <div class="container-fluid">
                    <div class="d-flex d-md-none d-block">
                        <button class="btn px-1 py-0 open-btn me-2 text-white open-menu" aria-label="Open sidebar">
                            <i class="bi bi-list"></i>
                        </button>
                        <img id="logoPreview"
                             src="<?php echo e(isset($siteSetting) && $siteSetting->logo ? asset('storage/' . $siteSetting->logo) : asset('assets/img/siteLogo.png')); ?>"
                             alt="Logo Preview" class="img-fluid"
                             style="height: 75px;">
                    </div>
                    <div class="d-flex flex-grow-1 justify-content-end" id="navbarSupportedContent">
                        <ul class="navbar-nav mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active text-white d-flex align-items-center" aria-current="page"
                                   href="<?php echo e(route('profileSettingPage')); ?>" title="View Profile">
                                    <img class="img-fluid d-block profile-image mx-2" src="<?php echo e($profileImage); ?>"
                                         alt="<?php echo e($profileImage); ?>">
                                    <?php echo e(auth()->user()->name); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <?php endif; ?>

            <section class="<?php echo e(auth()->check() ? 'dashboard-content px-3 pt-4' : ''); ?>">
                <?php if(auth()->user()): ?>
                <h1 class="mb-4"><?php echo $__env->yieldContent('title'); ?></h1>
                <?php endif; ?>
                <?php echo $__env->yieldContent('content'); ?>
            </section>


            <?php if(auth()->user()): ?>
        </main>
    </div>
    <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script src="<?php echo e(asset('assets/js/script.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/center.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/course.js')); ?>"></script>
</body>
<?php /**PATH /Users/raheel_safdar/PhpstormProjects/svn-technical/resources/views/layouts/app.blade.php ENDPATH**/ ?>