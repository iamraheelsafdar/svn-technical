<?php $__env->startSection('title', 'Centers'); ?>
<?php $__env->startSection('content'); ?>
    <div class="pb-4 d-flex justify-content-end align-items-center">
        <a href="<?php echo e(route('addCenterPage')); ?>" class="btn btn-primary">Add Center</a>
    </div>
    <div class="table-responsive d-block">
        <table class="table table-striped pagination-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Registration Date</th>
                <th>Registration Prefix</th>
                <th>Name</th>
                <th>Owner Name</th>
                <th>Email</th>


                <th>State</th>
                <th>Status</th>
                <th>Last Login</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <form action="<?php echo e(route('centersPage')); ?>" method="GET" class="d-flex justify-content-end">
                <tr>
                    <td>#</td>
                    <td>
                        <input class="form-control border-0" type="text" id="dateInput" name="date"
                               value="<?php echo e(request()->input('date')); ?>" placeholder="dd-mm-yyyy"/>
                    </td>
                    <td>
                        <input class="form-control border-0" type="text" name="prefix"
                               value="<?php echo e(request()->input('prefix')); ?>" placeholder="Search Registration Prefix"/>
                    </td>
                    <td>
                        <input class="form-control border-0" type="text" name="name"
                               value="<?php echo e(request()->input('name')); ?>" placeholder="Search Name"/>
                    </td>
                    <td>
                        <input class="form-control border-0" type="text" name="owner_name"
                               value="<?php echo e(request()->input('owner_name')); ?>" placeholder="Search Owner Name"/>
                    </td>
                    <td>
                        <input class="form-control border-0" type="text" name="email"
                               value="<?php echo e(request()->input('email')); ?>" placeholder="Search Email"/>
                    </td>








                    <td><input class="form-control border-0" type="text" name="state"
                               value="<?php echo e(request()->input('state')); ?>" placeholder="Search state"/></td>
                    <td>
                        <select class="form-control border-0" name="status">
                            <option value="" <?php echo e(old('status', request()->input('status')) == null ? 'selected' : 'disabled'); ?>>Select Status</option>
                            <option value="1" <?php echo e(old('status', request()->input('status')) == 1 ? 'selected' : ''); ?>>Active</option>
                            <option value="0" <?php echo e(old('status', request()->input('status')) == '0' ? 'selected' : ''); ?>>Inactive</option>
                        </select>
                    </td>
                    <td></td>
                    <td class="d-flex" >
                        <button class="btn btn-primary" type="submit">Search</button>
                        <a href="<?php echo e(route('centersPage')); ?>" class="btn btn-dark w-100 d-block ms-2" type="submit">Clear</a>
                    </td>

                </tr>
            </form>

            <?php $__empty_1 = true; $__currentLoopData = $centers['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e(($centers['current_page'] - 1) * $centers['per_page'] + $key + 1); ?></td>
                    <td><?php echo e($center['registration_date']); ?></td>
                    <td><?php echo e($center['registration_prefix']); ?></td>
                    <td><?php echo e($center['name']); ?></td>
                    <td><?php echo e($center['owner_name']); ?></td>
                    <td><?php echo e($center['email']); ?></td>


                    <td><?php echo e($center['state']); ?></td>
                    <td class="align-items-center">
                        <div class="form-check form-switch">
                            <input
                                class="form-check-input toggle-status text-center"
                                type="checkbox"
                                id="statusToggle<?php echo e($center['id']); ?>"
                                data-id="<?php echo e($center['id']); ?>"
                                data-type="center"
                                <?php echo e($center['status'] ? 'checked' : ''); ?>

                                onclick="showConfirmationModal(this)"
                            >
                        </div>
                    </td>
                    <td><?php echo e($center['last_login']); ?></td>
                    <td>
                        <a href="<?php echo e(route('updateCenterView', ['id' => $center['id']])); ?>" class="btn btn-primary">Edit</a>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="text-center">No records found</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php echo $__env->make('pagination.pagination', ['dataToPaginate' => $centers], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/raheel_safdar/PhpstormProjects/svn-technical/resources/views/center/centers.blade.php ENDPATH**/ ?>