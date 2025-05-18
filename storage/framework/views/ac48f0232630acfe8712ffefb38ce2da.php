<?php $__env->startSection('head'); ?>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Maru+Gothic&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('aptitude_result.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="result-wrapper">
    <div class="title">
        <div class="title1">STEM GATE</div>
        <div class="title2">企業データを活用して理工系女子の就職・就業をワンストップでサポート</div>
    </div>

    <div class="result-container">
        <h2 class="result-heading">診断結果</h2>
        <p class="result-subtitle">
            あなたの診断結果は　
            <span class="result-type"><?php echo e($type ?? '未分類'); ?></span>　タイプです
        </p>

        
        <div class="result-image">
            <img src="<?php echo e(asset('images/types/' . ($imageFile ?? 'default.png'))); ?>" alt="<?php echo e($type); ?>">
        </div>

        
        <div class="result-text">
            <?php echo nl2br(e($reason ?? '診断理由が取得できませんでした。')); ?>

        </div>

        
        <div class="recommendation">
            <p><strong>おすすめの業種：</strong><?php echo e($industry ?? 'ー'); ?></p>
            <p><strong>おすすめの職種：</strong><?php echo e($job ?? 'ー'); ?></p>
        </div>

        <div class="result-button-wrapper">
            <a href="<?php echo e(route('comps_database')); ?>" class="result-button">おすすめ業種の企業一覧はこちら</a>
        </div>
    </div>

    <footer class="copyright">
        copyrights 2024 Wom-tech All Rights Reserved.
    </footer>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/gs-laravel/resources/views/aptitude_test/result.blade.php ENDPATH**/ ?>