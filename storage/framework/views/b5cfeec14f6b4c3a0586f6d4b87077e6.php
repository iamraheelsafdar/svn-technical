<?php $__env->startSection('title', 'Prefixes'); ?>
<?php $__env->startSection('content'); ?>
    <div class="pb-4 d-flex justify-content-end align-items-center">
        <a href="<?php echo e(route('addPrefixPage')); ?>" class="btn btn-primary">Add Prefix</a>
    </div>


    <div class="table-responsive d-block">
        <table class="table table-striped pagination-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Prefix Name</th>
                <th>Prefix Assign To</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <form action="<?php echo e(route('prefixesPage')); ?>" method="GET" class="d-flex justify-content-end">
                <tr>
                    <td>#</td>
                    <td>
                        <input class="form-control border-0" type="text" name="prefix_name"
                               value="<?php echo e(request()->input('prefix_name')); ?>" placeholder="Search Prefix"/>
                    </td>
                    <td>
                        <select class="form-control border-0" name="assign_prefix">
                            <option value="" <?php echo e(old('assign_prefix', request()->input('assign_prefix')) == null ? 'selected' : 'disabled'); ?>>Select Status</option>
                            <?php $__currentLoopData = $assignedPrefixes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignedPrefix): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($assignedPrefix); ?>" <?php echo e(old('assign_prefix', request()->input('assign_prefix')) == $assignedPrefix ? 'selected' : ''); ?>>
                                    <?php echo e($assignedPrefix); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </td>
                    <td>
                        <select class="form-control border-0" name="status">
                            <option value="" <?php echo e(old('status', request()->input('status')) == null ? 'selected' : 'disabled'); ?>>Select Status</option>
                            <option value="1" <?php echo e(old('status', request()->input('status')) == 1 ? 'selected' : ''); ?>>Active</option>
                            <option value="0" <?php echo e(old('status', request()->input('status')) == '0' ? 'selected' : ''); ?>>Inactive</option>
                        </select>
                    </td>
                    <td>
                        <input class="form-control border-0" type="text" id="dateInput" name="date"
                               value="<?php echo e(request()->input('date')); ?>" placeholder="dd-mm-yyyy"/>
                    </td>
                    <td class="d-flex" >
                        <button class="btn btn-primary" type="submit">Search</button>
                        <a href="<?php echo e(route('prefixesPage')); ?>" class="btn btn-dark w-100 d-block ms-2" type="submit">Clear</a>
                    </td>


                </tr>
            </form>

            <?php $__empty_1 = true; $__currentLoopData = $prefixes['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $prefix): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e(($prefixes['current_page'] - 1) * $prefixes['per_page'] + $key + 1); ?></td>
                    <td><?php echo e($prefix['prefix']); ?></td>
                    <td><?php echo e($prefix['prefix_assign_to']); ?></td>
                    <td>
                        <div class="form-check form-switch">
                            <input
                                class="form-check-input toggle-status text-center"
                                type="checkbox"
                                id="statusToggle<?php echo e($prefix['id']); ?>"
                                data-id="<?php echo e($prefix['id']); ?>"
                                data-type="prefix"
                                <?php echo e($prefix['status'] ? 'checked' : ''); ?>

                                onclick="showConfirmationModal(this)"
                            >
                        </div>
                    </td>
                    <td><?php echo e($prefix['created_at']); ?></td>
                    <td>
                        <a href="<?php echo e(route('updatePrefixView', ['id' => $prefix['id']])); ?>" class="btn btn-primary">Edit</a>
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

    <?php echo $__env->make('pagination.pagination', ['dataToPaginate' => $prefixes], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/raheel_safdar/PhpstormProjects/svn-technical/resources/views/prefix/prefixes.blade.php ENDPATH**/ ?>