<?php $__env->startSection('title', 'Enrollments'); ?>
<?php $__env->startSection('content'); ?>
    <div class="pb-4 d-flex justify-content-end align-items-center">
        <a href="<?php echo e(route('addEnrollmentPage')); ?>" class="btn btn-primary">Add Enrollment</a>
    </div>
    <div class="table-responsive d-block">
        <table class="table table-striped pagination-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Enrollment Name</th>
                <th>Enrollment Prefix</th>
                <th>Stream Name</th>
                <th>Year Start</th>
                <th>Create At</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <form action="<?php echo e(route('enrollmentsPage')); ?>" method="GET" class="d-flex justify-content-end">
                <tr>
                    <td>#</td>
                    <td>
                        <input class="form-control border-0" type="text" name="enrollment_name"
                               value="<?php echo e(request()->input('enrollment_name')); ?>" placeholder="Search Enrollment Name"/>
                    </td>
                    <td>
                        <input class="form-control border-0" type="text" name="prefix_name"
                               value="<?php echo e(request()->input('prefix_name')); ?>" placeholder="Search Prefix Name"/>
                    </td>
                    <td>
                        <input class="form-control border-0" type="text" name="stream_name"
                               value="<?php echo e(request()->input('stream_name')); ?>" placeholder="Search Stream Name"/>
                    </td>
                    <td>
                        <input class="form-control border-0" type="text" name="enrollment_year"
                               value="<?php echo e(request()->input('enrollment_year')); ?>" placeholder="Search Enrollment Year"/>
                    </td>
                    <td>
                        <input class="form-control border-0" type="text" id="dateInput" name="date"
                               value="<?php echo e(request()->input('date')); ?>" placeholder="dd-mm-yyyy"/>
                    </td>
                    <td>
                        <select class="form-control border-0" name="status">
                            <option value="" <?php echo e(old('status', request()->input('status')) == null ? 'selected' : 'disabled'); ?>>Select Status</option>
                            <option value="1" <?php echo e(old('status', request()->input('status')) == 1 ? 'selected' : ''); ?>>Active</option>
                            <option value="0" <?php echo e(old('status', request()->input('status')) == '0' ? 'selected' : ''); ?>>Inactive</option>
                        </select>
                    </td>
                    <td class="d-flex" >
                        <button class="btn btn-primary" type="submit">Search</button>
                        <a href="<?php echo e(route('enrollmentsPage')); ?>" class="btn btn-dark w-100 d-block ms-2" type="submit">Clear</a>
                    </td>

                </tr>
            </form>

            <?php $__empty_1 = true; $__currentLoopData = $enrollments['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e(($enrollments['current_page'] - 1) * $enrollments['per_page'] + $key + 1); ?></td>
                    <td><?php echo e($enrollment['enrollment_name']); ?></td>
                    <td><?php echo e($enrollment['prefix_name']); ?></td>
                    <td><?php echo e($enrollment['stream_name']); ?></td>
                    <td><?php echo e($enrollment['enrollment_year']); ?></td>
                    <td><?php echo e($enrollment['created_at']); ?></td>
                    <td class="align-items-center">
                        <div class="form-check form-switch">
                            <input
                                class="form-check-input toggle-status text-center"
                                type="checkbox"
                                id="statusToggle<?php echo e($enrollment['id']); ?>"
                                data-id="<?php echo e($enrollment['id']); ?>"
                                data-type="enrollment"
                                <?php echo e($enrollment['status'] ? 'checked' : ''); ?>

                                onclick="showConfirmationModal(this)"
                            >
                        </div>
                    </td>
                    <td>
                        <a href="<?php echo e(route('updateEnrollmentView', ['id' => $enrollment['id']])); ?>" class="btn btn-primary">Edit</a>
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

    <?php echo $__env->make('pagination.pagination', ['dataToPaginate' => $enrollments], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/raheel_safdar/PhpstormProjects/svn-technical/resources/views/enrollment/enrollments.blade.php ENDPATH**/ ?>