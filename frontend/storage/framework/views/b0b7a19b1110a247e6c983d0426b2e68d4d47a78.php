<style>
    .custom-pagination {
        display: flex;
        gap: 8px;
        list-style: none;
        padding: 0;
        margin: 0;
        align-items: center;
    }
    .custom-pagination .page-item .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        border-radius: 4px;
        background-color: #f1f5f9;
        color: #4b5563;
        font-weight: 500;
        font-size: 14px;
        text-decoration: none;
        border: none;
        transition: all 0.3s ease;
    }
    .custom-pagination .page-item.active .page-link {
        background-color: #3BB77E;
        color: white;
    }

    .custom-pagination .page-item:not(.active) .page-link:hover {
        background-color: #e2e8f0;
    }
    .custom-pagination .page-item.disabled .page-link {
        color: #9ca3af;
        cursor: not-allowed;
    }
    .custom-pagination .page-item .page-link.dots {
        background-color: transparent !important;
        color: #3BB77E !important;
        font-size: 36px;
        letter-spacing: 5px;
        line-height: 8px;
        width: auto;
        font-weight: 800;
        padding-top: 5px;
    }
    .custom-pagination .page-item:first-child .page-link,
    .custom-pagination .page-item:last-child .page-link {
        border-radius: 4px !important;
    }
    /* Mobile compact view */
    @media(max-width: 575px) {
        .custom-pagination {
            gap: 4px;
        }
        .custom-pagination .page-item .page-link {
            min-width: 28px;
            width: 28px;
            height: 28px;
            font-size: 11px;
            padding: 0;
        }
        .custom-pagination .page-item .page-link.dots {
            font-size: 24px;
            letter-spacing: 2px;
        }
    }
</style>

<?php if($paginator->hasPages()): ?>
    <nav>
        <ul class="pagination justify-content-center custom-pagination">
            
            <?php if($paginator->onFirstPage()): ?>
                <li class="page-item disabled" aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.previous'); ?>">
                    <span class="page-link" aria-hidden="true">&laquo;</span>
                </li>
            <?php else: ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" aria-label="<?php echo app('translator')->get('pagination.previous'); ?>">&laquo;</a>
                </li>
            <?php endif; ?>

            
            <?php $__currentLoopData = $paginator->getUrlRange(1, $paginator->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($page == $paginator->currentPage()): ?>
                    <li class="page-item active" aria-current="page"><span class="page-link"><?php echo e(sprintf('%02d', $page)); ?></span></li>
                <?php else: ?>
                    <?php if($page == 1 || $page == $paginator->lastPage() || abs($page - $paginator->currentPage()) <= 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo e($url); ?>"><?php echo e(sprintf('%02d', $page)); ?></a>
                        </li>
                    <?php elseif(abs($page - $paginator->currentPage()) == 2): ?>
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link dots" style="border: none;">...</span>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" aria-label="<?php echo app('translator')->get('pagination.next'); ?>">&raquo;</a>
                </li>
            <?php else: ?>
                <li class="page-item disabled" aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.next'); ?>">
                    <span class="page-link" aria-hidden="true">&raquo;</span>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\chennais\frontend\resources\views/vendor/pagination/custom.blade.php ENDPATH**/ ?>