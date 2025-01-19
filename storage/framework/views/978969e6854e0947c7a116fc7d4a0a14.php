<?php $__env->startSection('title', 'Site Setting'); ?>
<?php $__env->startSection('content'); ?>
    <div class="pb-4">
        <form class="row" action="<?php echo e(route('updateSetting')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <div class="col-6 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control"
                       value="<?php echo e($siteSetting->email ?? old('email')); ?>"
                       placeholder="Enter email">
            </div>

            <div class="col-6 mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control"
                       value="<?php echo e($siteSetting->phone ?? old('phone')); ?>"
                       placeholder="Enter phone number">

            </div>

            <div class="col-6 mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control"
                       value="<?php echo e($siteSetting->title ?? old('title')); ?>"
                       placeholder="Enter title">
            </div>

            <div class="col-6 mb-3">
                <label for="copyright" class="form-label">Copyright</label>
                <input type="text" name="copyright" id="copyright" class="form-control"
                       value="<?php echo e($siteSetting->copyright ?? old('copyright')); ?>"
                       placeholder="Enter copyright text">
            </div>

            <div class=" mb-3">
                <label for="logo" class="form-label">Logo</label>
                <div class="d-flex align-items-center">
                    <img id="logoPreview" src="<?php echo e(isset($siteSetting) && $siteSetting->logo ? asset('storage/' . $siteSetting->logo) : asset('assets/img/siteLogo.png')); ?>" alt="Logo Preview"
                         style="max-width: 46px; <?php echo e(isset($siteSetting) && $siteSetting->logo ? '' : 'display: none;'); ?>" class="img-thumbnail">
                    <input type="file" name="logo" id="logo" class="form-control">
                </div>
            </div>

            <button type="submit" class="btn btn-primary form-button mx-auto w-auto">Submit</button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/raheel_safdar/PhpstormProjects/svn-technical/resources/views/dashboard/site-setting.blade.php ENDPATH**/ ?>