<?php $__env->startSection('title', 'Login'); ?>
<?php $__env->startSection('content'); ?>
    <section class="login-section" style="background-image:url(<?php echo e(asset('assets/img/loginPageImage.png')); ?>);">
        <div class="overlay"></div>
        <div class="login-form-container">
            <div class="form-box">
                <h2 class="mb-4 text-dark">Login to <span class="title">SVN Technical</span></h2>
                <form method="POST" action="<?php echo e(route('login')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" class="form-control" placeholder="Enter email">
                    </div>
                    <div class="mb-3">
                        <input type="password" id="password" name="password" value="<?php echo e(old('password')); ?>" class="form-control"
                               placeholder="Enter password">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 form-button">Login</button>
                </form>
                <div class="mt-3">
                    <a href="<?php echo e(route('forgotPasswordPage')); ?>" class="text-primary">Forgot password?</a>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/raheel_safdar/PhpstormProjects/svn-technical/resources/views/auth/login.blade.php ENDPATH**/ ?>