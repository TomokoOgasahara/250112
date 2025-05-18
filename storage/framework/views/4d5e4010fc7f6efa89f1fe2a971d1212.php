<?php $__env->startSection('head'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('review.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="title">
        <div class="title1">STEM GATE</div>
        <div class="title2">企業データを活用して理工系女子の就職をワンストップでサポート</div>
</div>

<div class="container">
<h2>口コミ一覧</h2>

<!-- プルダウンで企業名選択 -->
<div class="form-container" style="margin: 2rem 0;">
    <form method="GET" action="<?php echo e(route('review')); ?>">
        <label for="comp_name">企業名を選択してください：</label>
        <select name="comp_name" id="comp_name" required>
            <option value="">--選択してください--</option>
            <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($company->comp_name); ?>" <?php echo e(request('comp_name') === $company->comp_name ? 'selected' : ''); ?>>
                    <?php echo e($company->comp_name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <button type="submit">検索</button>
    </form>
</div>
</div>


<?php if(session('success')): ?>
    <p style="color: green;"><?php echo e(session('success')); ?></p>
<?php endif; ?>

<?php if(session('error')): ?>
    <p style="color: red;"><?php echo e(session('error')); ?></p>
<?php endif; ?>

<?php if($review && $review->isNotEmpty()): ?>
    <?php $__currentLoopData = $review; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reviews): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="review-card">
        <div class="review-header">
            <h3>
                <?php echo e($reviews->name); ?> さん
            </h3>

            
            <?php if(Auth::check() && $reviews->user_id && Auth::id() !== $reviews->user_id): ?>
                <form method="POST" action="<?php echo e(route('consult.request', ['to_user_id' => $reviews->user_id])); ?>" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="button-consult">相談する</button>
                </form>
            <?php endif; ?>

            <div class="review-rating">
                クチコミ総合評価 
                <span class="stars">
                    <?php echo e(str_repeat('★', $reviews->growth_potential)); ?>

                    <?php echo e(str_repeat('☆', 5 - $reviews->growth_potential)); ?>

                </span>
            </div>
        </div>

        <div class="review-details">
            回答者: <?php echo e($reviews->employment_status); ?>／<?php echo e($reviews->speciality); ?>／<?php echo e($reviews->years_of_service); ?>／<?php echo e($reviews->age_group); ?>／<?php echo e($reviews->employment_type); ?>

        </div>

        <div class="review-comment">
            <?php echo e($reviews->reviews); ?>

        </div>
    </div>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
    <p>口コミデータがありません。</p>
<?php endif; ?>

<footer class="copyright">
        copyrights 2024 Wom-tech All Rights Reserved.
</footer>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/gs-laravel/resources/views/review.blade.php ENDPATH**/ ?>