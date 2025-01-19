<?php $__env->startSection('title', 'Edit Prefix'); ?>
<?php $__env->startSection('content'); ?>
    <div class="pb-4">
        <form class="row" action="<?php echo e(route('updatePrefix')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="col-6 mb-3">
                <label for="prefix_name" class="form-label">Prefix Name</label>
                <input type="text" name="prefix_name" id="prefix_name" class="form-control"
                       value="<?php echo e($prefix->prefix); ?>"
                       placeholder="Enter Prefix Name"
                >
                <input type="hidden" name="id" id="id" class="form-control"
                       value="<?php echo e($prefix->id); ?>"
                >
            </div>
            <div class="col-6 mb-3">
                <label for="assign_prefix" class="form-label">Assign Prefix</label>
                <select id="assign_prefix" name="assign_prefix" class="form-select" aria-label="Default select example">
                    <option value="<?php echo e($prefix->prefix_assign_to); ?>"><?php echo e($prefix->prefix_assign_to); ?></option>
                    <?php $__currentLoopData = $assignPrefixes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignPrefix): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($assignPrefix); ?>"><?php echo e($assignPrefix); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary form-button w-auto mx-auto">Update Prefix</button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/raheel_safdar/PhpstormProjects/svn-technical/resources/views/prefix/update-prefix.blade.php ENDPATH**/ ?>