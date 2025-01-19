<div class="d-flex justify-content-center">
    <?php if($dataToPaginate['current_page'] > 1): ?>
        <a href="<?php echo e($dataToPaginate['path'] . '?page=1' . '&' . http_build_query(request()->except('page'))); ?>" class="btn btn-primary me-2">
            <i class="bi bi-chevron-double-left"></i> First
        </a>
    <?php else: ?>
        <button class="btn btn-secondary me-2" disabled>
            <i class="bi bi-chevron-double-left"></i> First
        </button>
    <?php endif; ?>

    <?php if($dataToPaginate['prev_page_url']): ?>
        <a href="<?php echo e($dataToPaginate['prev_page_url'] . '&' . http_build_query(request()->except('page'))); ?>" class="btn btn-primary me-2">
            <i class="bi bi-chevron-left"></i> Previous
        </a>
    <?php else: ?>
        <button class="btn btn-secondary me-2" disabled>
            <i class="bi bi-chevron-left"></i> Previous
        </button>
    <?php endif; ?>

    <?php if($dataToPaginate['has_more_pages']): ?>
        <a href="<?php echo e($dataToPaginate['next_page_url'] . '&' . http_build_query(request()->except('page'))); ?>" class="btn btn-primary me-2">
            Next <i class="bi bi-chevron-right"></i>
        </a>
    <?php else: ?>
        <button class="btn btn-secondary me-2" disabled>
            Next <i class="bi bi-chevron-right"></i>
        </button>
    <?php endif; ?>

    <?php if($dataToPaginate['has_more_pages']): ?>
        <a href="<?php echo e($dataToPaginate['path'] . '?page=' . ceil($dataToPaginate['total'] / $dataToPaginate['per_page']) . '&' . http_build_query(request()->except('page'))); ?>"
           class="btn btn-primary">
            Last <i class="bi bi-chevron-double-right"></i>
        </a>
    <?php else: ?>
        <button class="btn btn-secondary" disabled>
            Last <i class="bi bi-chevron-double-right"></i>
        </button>
    <?php endif; ?>
</div>
<?php /**PATH /Users/raheel_safdar/PhpstormProjects/svn-technical/resources/views/pagination/pagination.blade.php ENDPATH**/ ?>