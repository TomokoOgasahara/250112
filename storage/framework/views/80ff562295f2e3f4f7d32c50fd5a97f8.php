<?php $__env->startSection('content'); ?>
    <div class="title">
        <div class="title1">STEM GATE</div>
        <div class="title2">企業データを活用して理工系女子の就職をワンストップでサポート</div>
    </div>

    <div class="main-wrapper">
        <div class="container">
            <h2 class="question-title">質問 <?php echo e($currentStep); ?> / <?php echo e($totalSteps); ?></h2>

            <form method="POST" action="<?php echo e($isLast ? route('aptitude_test.submit') : route('aptitude_test.next')); ?>">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="step" value="<?php echo e($currentStep); ?>">
                <p class="question-title"><?php echo e($question['text']); ?></p>

                <?php if($question['type'] === 'text'): ?>
                    <textarea name="answer" required class="aptitude-button" rows="3"><?php echo e(old('answer')); ?></textarea>

                    <div class="mt-4 text-center">
                        <button type="submit" class="aptitude-button">次へ進む</button>
                    </div>
                <?php elseif($question['type'] === 'radio'): ?>
                <div class="options-wrapper">
                        <?php $__currentLoopData = $question['options']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <button type="submit" name="answer" value="<?php echo e($value); ?>" class="aptitude-button">
                <?php echo e($label); ?>

            </button>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php endif; ?>
            </form>
        </div>
    </div>
    </div>
    <footer class="copyright">
        copyrights 2024 Wom-tech All Rights Reserved.
    </footer>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/gs-laravel/resources/views/aptitude_test/form.blade.php ENDPATH**/ ?>