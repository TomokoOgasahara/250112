<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>STEM GATE - 適職診断</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    
    <link href="https://fonts.googleapis.com/css2?family=Zen+Maru+Gothic:wght@400;500;700&display=swap" rel="stylesheet">

    
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>

    
    <link rel="stylesheet" href="<?php echo e(asset('aptitude_test.css')); ?>">

    
    <?php echo $__env->yieldContent('head'); ?>
</head>

<body class="bg-gray-100">
    <?php echo $__env->yieldContent('content'); ?>
</body>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/gs-laravel/resources/views/layouts/app.blade.php ENDPATH**/ ?>