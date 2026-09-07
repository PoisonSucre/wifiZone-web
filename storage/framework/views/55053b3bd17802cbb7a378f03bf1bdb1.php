<!DOCTYPE html>
<html lang="fr" class="scroll-smooth <?php echo e($themeClass); ?>">
<head>
    <script>(function(){var t=localStorage.getItem('theme')||document.cookie.match(/theme=([^;]+)/)?.[1]||'light';if(t==='dark')document.documentElement.classList.add('dark');})();</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('favicon.svg')); ?>">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <title><?php echo $__env->yieldContent('title', 'Connexion'); ?> — <?php echo e(config('platform.name')); ?></title>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>
<body class="bg-slate-50 text-slate-800 dark:bg-darkBg dark:text-gray-100 font-sans antialiased min-h-screen flex flex-col justify-between transition-colors duration-300 relative overflow-x-hidden">

    <!-- Background decorations -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-neonGreen/5 rounded-full filter blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-neonGreen/5 rounded-full filter blur-3xl"></div>
    </div>

    <?php if (isset($component)) { $__componentOriginal1668b5f9e130953f2bdbf60b1b291cc8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1668b5f9e130953f2bdbf60b1b291cc8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar-public','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navbar-public'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1668b5f9e130953f2bdbf60b1b291cc8)): ?>
<?php $attributes = $__attributesOriginal1668b5f9e130953f2bdbf60b1b291cc8; ?>
<?php unset($__attributesOriginal1668b5f9e130953f2bdbf60b1b291cc8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1668b5f9e130953f2bdbf60b1b291cc8)): ?>
<?php $component = $__componentOriginal1668b5f9e130953f2bdbf60b1b291cc8; ?>
<?php unset($__componentOriginal1668b5f9e130953f2bdbf60b1b291cc8); ?>
<?php endif; ?>

    <main class="flex-grow flex items-center justify-center px-4 sm:px-6 lg:px-8 pt-28 pb-12 relative z-10 w-full">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('toast');

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-438636015-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
    <?php if (isset($component)) { $__componentOriginal3fc50f1b466d8de08ec1a67adc2d949f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fc50f1b466d8de08ec1a67adc2d949f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.flash-toast','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flash-toast'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fc50f1b466d8de08ec1a67adc2d949f)): ?>
<?php $attributes = $__attributesOriginal3fc50f1b466d8de08ec1a67adc2d949f; ?>
<?php unset($__attributesOriginal3fc50f1b466d8de08ec1a67adc2d949f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fc50f1b466d8de08ec1a67adc2d949f)): ?>
<?php $component = $__componentOriginal3fc50f1b466d8de08ec1a67adc2d949f; ?>
<?php unset($__componentOriginal3fc50f1b466d8de08ec1a67adc2d949f); ?>
<?php endif; ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/layouts/auth.blade.php ENDPATH**/ ?>