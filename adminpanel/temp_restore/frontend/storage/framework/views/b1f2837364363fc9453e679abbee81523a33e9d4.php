<style>
    .card-2 {
        height: 200px !important;
        min-height: 200px !important;
        max-height: 200px !important;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        overflow: hidden;
        padding: 10px !important;
        box-sizing: border-box;
    }

    .card-2 figure {
        /* height: 100px !important;
        min-height: 100px !important;
        max-height: 100px !important; */
        overflow: hidden;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-2 figure img {
        width: 100%;
        height: 100px !important;
        max-height: 100px !important;
        object-fit: cover;
        border-radius: 6px;
    }

    .card-2 h6 {
        height: 40px !important;
        min-height: 40px !important;
        max-height: 40px !important;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
        overflow: hidden;
        text-align: center;
        font-size: 13px;
    }

    .card-2 h6 a {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.3;
    }

    .card-2 span {
        flex-shrink: 0;
        font-size: 12px;
    }
</style>
<div class="carausel-10-columns-cover arrow-center position-relative">
    <div class="slider-arrow slider-arrow-2 carausel-10-columns-arrow" id="carausel-10-columns-arrows"></div>
    <div class="carausel-10-columns carausel-arrow-center" id="carausel-10-columns">
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card-2 bg-<?php echo e(($loop->index % 6) + 9); ?> wow animate__animated animate__fadeInUp"
                data-wow-delay=".<?php echo e($loop->iteration); ?>s">
                <figure class="img-hover-scale overflow-hidden">
                    <a href="<?php echo e(route('category.products', $category->id)); ?>">
                        <img src="<?php echo e(config('app.admin_asset_url')); ?>/maincategory/<?php echo e(basename($category->image)); ?>"
                            alt="<?php echo e($category->name); ?>"
                            onerror="this.src='<?php echo e(asset('assets/imgs/theme/icons/category-1.svg')); ?>'" />
                    </a>
                </figure>

                <h6>
                    <a href="<?php echo e(route('category.products', $category->id)); ?>"><?php echo e($category->name); ?></a>
                </h6>

                <span><?php echo e($category->products_count); ?> Available</span>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div><?php /**PATH C:\xampp\htdocs\chennai\frontend\resources\views/section/Category.blade.php ENDPATH**/ ?>