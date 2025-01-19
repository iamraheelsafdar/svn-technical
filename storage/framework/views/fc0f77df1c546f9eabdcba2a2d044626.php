<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>
    <div class="bg-primary mx-auto text-center p-3 d-flex align-items-center justify-content-between"><h2 class="mb-0">
            Welcome, <?php echo e(auth()->user()->name); ?> ! </h2>
        <div class="ms-4 clock">
            <div class="center"></div>
            <div class="hand hour" id="hour"></div>
            <div class="hand minute" id="minute"></div>
            <div class="hand second" id="second"></div>
        </div>
    </div>
    <div class="container my-5">
        <div class="row">
            <!-- Card 1 -->
            <div class="col-md-3 mb-4">
                <div class="card bg-primary-custom text-white shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Centers</h5>
                                <p class="mb-0">Active: <?php echo e($details['active_centers']); ?></p>
                                <p>Inactive: <?php echo e($details['inactive_centers']); ?></p>
                                <h6>Total: <?php echo e($details['total_centers']); ?></h6>
                            </div>
                            <i class="bi bi-people-fill card-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-md-3 mb-4">
                <div class="card bg-success-custom text-white shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Students</h5>
                                <p class="mb-0">Active: 45</p>
                                <p>Inactive: 5</p>
                                <h6>Total: 50</h6>
                            </div>
                            <i class="bi bi-book-fill card-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="col-md-3 mb-4">
                <div class="card bg-danger-custom text-white shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Enrollment</h5>
                                <p class="mb-0">Active: <?php echo e($details['active_enrollments']); ?></p>
                                <p>Inactive: <?php echo e($details['inactive_enrollments']); ?></p>
                                <h6>Total: <?php echo e($details['total_enrollments']); ?></h6>
                            </div>
                            <i class="bi bi-mortarboard-fill  card-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card 4 -->
            <div class="col-md-3 mb-4">
                <div class="card bg-warning-custom shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title">Feedback</h5>
                                <p class="mb-0">Positive: 300</p>
                                <p>Negative: 20</p>
                                <h6>Total: 320</h6>
                            </div>
                            <i class="bi bi-chat-left-text-fill card-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/raheel_safdar/PhpstormProjects/svn-technical/resources/views/dashboard/dashboard.blade.php ENDPATH**/ ?>