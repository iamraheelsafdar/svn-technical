<?php $__env->startSection('title', 'Edit Center'); ?>
<?php $__env->startSection('content'); ?>
    <div class="pb-4">
        <form class="row" action="<?php echo e(route('updateCenter')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="id" id="reg_number" class="form-control" readonly
                   value="<?php echo e($center->id); ?>"
            >
            <div class="col-6 mb-3">
                <label for="reg_number" class="form-label">Center Reg No</label>
                <input type="text" name="reg_number" id="reg_number" class="form-control" readonly
                       value="<?php echo e($center->registration_prefix); ?>"
                >
            </div>
            <div class="col-6 mb-3">
                <label for="email" class="form-label">Center Email</label>
                <input type="email" id="email" class="form-control" name="email"
                       value="<?php echo e($center->user->email); ?>"
                       placeholder="Enter email">
            </div>

            <div class="col-6 mb-3">
                <label for="name" class="form-label">Center Name</label>
                <input type="text" name="name" id="name" class="form-control"
                       value="<?php echo e($center->user->name); ?>"
                       placeholder="Enter center name">
            </div>

            <div class="col-6 mb-3">
                <label for="owner_name" class="form-label">Center Owner Name</label>
                <input type="text" name="owner_name" id="owner_name" class="form-control"
                       value="<?php echo e($center->owner_name); ?>"
                       placeholder="Enter center owner name">
            </div>

            <div class="col-6 mb-3">
                <label for="phone" class="form-label">Center Mobile</label>
                <input type="text" name="phone" id="phone" class="form-control"
                       value="<?php echo e($center->user->phone); ?>"
                       placeholder="Enter center mobile">

            </div>
            <div class="col-6 mb-3">
                <label for="logo" class="form-label">Center Logo</label>
                <img src="" alt="">
                <div class="d-flex align-items-center">
                    <img id="profileImage" src="<?php echo e(asset('storage/' . $center->user->profile_image)); ?>"
                         alt="Logo Preview"
                         style="max-width: 46px;" class="img-thumbnail">
                    <input type="file" name="profile_image" id="logo" class="form-control">
                </div>
            </div>
            <div class="col-6 mb-3">
                <label for="logo" class="form-label">Select State</label>
                <select name="state" class="form-select" aria-label="Default select example">
                    <?php
                        $states = array("Andaman and Nicobar Islands","Andhra Pradesh","Arunachal
                Pradesh","Assam","Bihar","Chandigarh","Chhattisgarh","Dadra and Nagar Haveli","Daman and
                Diu","Delhi","Goa","Gujarat","Haryana","Himachal Pradesh","Jammu and
                Kashmir","Jharkhand","Karnataka","Lakshadweep","Puducherry","Kerala","Madhya
                Pradesh","Maharashtra","Manipur","Meghalaya","Mizoram","Nagaland","Odisha","Punjab","Rajasthan","Sikkim","Tamil
                Nadu","Telangana","Tripura","Uttarakhand","Uttar Pradesh","West Bengal");
                    ?>
                    <option selected><?php echo e($center->state); ?></option>
                    <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($state); ?>"><?php echo e($state); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="col-6 mb-3">
                <label for="address" class="form-label">Center Address</label>
                <input type="text" name="address" id="address" class="form-control"
                       value="<?php echo e($center->address); ?>"
                       placeholder="Enter center address">
            </div>
            <button type="submit" class="btn btn-primary form-button w-auto mx-auto">Update</button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/raheel_safdar/PhpstormProjects/svn-technical/resources/views/center/update-centers.blade.php ENDPATH**/ ?>