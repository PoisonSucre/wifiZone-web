<!DOCTYPE html>
<html lang="fr" class="scroll-smooth <?php echo e($themeClass); ?>">
<head>
    <script>(function(){var t=localStorage.getItem('theme')||document.cookie.match(/theme=([^;]+)/)?.[1]||'light';if(t==='dark')document.documentElement.classList.add('dark');})();</script>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <title><?php echo e($vendeur->prenom ?? ''); ?> <?php echo e($vendeur->nom ?? ''); ?> - <?php echo e(config('platform.name')); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif; background: #f5f6fa; min-height: 100vh; display: flex; flex-direction: column; }
        .hero { background: linear-gradient(135deg, <?php echo e($vendeur->couleur ?? '#1ca04e'); ?>, <?php echo e($vendeur->couleur ?? '#1ca04e'); ?>cc); color: white; text-align: center; padding: 30px 15px 25px; }
        .hero h1 { font-size: 1.3em; margin-bottom: 8px; }
        .hero h1 i { margin-right: 6px; }
        .hero p { font-size: 0.9em; opacity: 0.9; }
        .hero .logo { max-width: 90px; max-height: 60px; border-radius: 10px; margin-bottom: 10px; display: block; margin-left: auto; margin-right: auto; }
        .hero .message { max-width: 500px; margin: 10px auto 0; font-size: 0.85em; opacity: 0.85; line-height: 1.5; }
        .tarifs { max-width: 800px; margin: 0 auto; padding: 20px 15px; }
        .tarifs h2 { text-align: center; color: #1a1a2e; margin-bottom: 15px; font-size: 1.1em; }
        .tarifs h2 i { color: <?php echo e($vendeur->couleur ?? '#1ca04e'); ?>; margin-right: 6px; }
        .tarif-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 12px; }
        .tarif-card { background: white; border-radius: 12px; padding: 15px 10px; text-align: center; box-shadow: 0 3px 15px rgba(0,0,0,0.08); transition: transform 0.2s; border-top: 4px solid <?php echo e($vendeur->couleur ?? '#1ca04e'); ?>; }
        .tarif-card:hover { transform: translateY(-3px); }
        .tarif-card .duration { font-size: 0.95em; font-weight: 700; color: #1a1a2e; margin-bottom: 6px; }
        .tarif-card .price { font-size: 1.5em; font-weight: 800; color: <?php echo e($vendeur->couleur ?? '#1ca04e'); ?>; }
        .tarif-card .currency { font-size: 0.75em; color: #999; margin-bottom: 10px; }
        .tarif-card .btn-payer { display: inline-block; background: <?php echo e($vendeur->couleur ?? '#1ca04e'); ?>; color: white; border: none; border-radius: 20px; padding: 7px 16px; font-weight: 700; cursor: pointer; text-decoration: none; font-size: 0.8em; transition: opacity 0.2s; }
        .tarif-card .btn-payer:hover { opacity: 0.85; }
        .tarif-card .btn-payer i { margin-right: 4px; }
        .extra { text-align: center; padding: 20px 15px; }
        .extra a { color: <?php echo e($vendeur->couleur ?? '#1ca04e'); ?>; font-weight: 700; text-decoration: none; }
        .extra a:hover { text-decoration: underline; }
        footer { margin-top: auto; text-align: center; padding: 15px; color: #999; font-size: 0.75em; }
        .dark body, body.dark { background: #0A0A0C !important; }
        .dark .tarif-card, body.dark .tarif-card { background: #121216; }
        .dark .tarif-card .duration, body.dark .tarif-card .duration { color: #f3f4f6; }
        .dark .tarif-card .currency, body.dark .tarif-card .currency { color: #9CA3AF; }
    </style>
</head>
<body>
    <div class="hero">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($vendeur->logo): ?>
            <img src="<?php echo e(asset($vendeur->logo)); ?>" alt="Logo" class="logo">
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <h1><i class="fas fa-wifi"></i> <?php echo e($vendeur->prenom ?? ''); ?> <?php echo e($vendeur->nom ?? ''); ?></h1>
        <p><?php echo e(config('platform.name')); ?></p>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($vendeur->message_bienvenue): ?>
            <div class="message"><?php echo e($vendeur->message_bienvenue); ?></div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div class="tarifs">
        <h2><i class="fas fa-tags"></i> Forfaits disponibles</h2>
        <div class="tarif-grid">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $forfaits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $forfait): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="tarif-card">
                <div class="duration"><?php echo e($forfait->label); ?></div>
                <div class="price"><?php echo e(number_format($forfait->montant)); ?></div>
                <div class="currency"><?php echo e(config('platform.currency', 'XOF')); ?></div>
                <form action="<?php echo e(url('/api/payment-process')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="vendeur_id" value="<?php echo e($vendeur->id); ?>">
                    <input type="hidden" name="montant" value="<?php echo e($forfait->montant); ?>">
                    <input type="hidden" name="forfait" value="<?php echo e($forfait->label); ?>">
                    <button type="submit" class="btn-payer"><i class="fas fa-shopping-cart"></i> Payer</button>
                </form>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <div class="no-forfaits" style="grid-column: 1/-1;">
                <i class="fas fa-info-circle"></i> Aucun forfait disponible pour le moment.
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <div class="extra">
        <a href="<?php echo e(url('/')); ?>"><i class="fas fa-arrow-left"></i> Retour à l'accueil</a>
    </div>

    <footer>
        <i class="fas fa-wifi" style="color:<?php echo e($vendeur->couleur ?? '#1ca04e'); ?>;"></i>
        <?php echo e(config('platform.name')); ?> &copy; <?php echo e(date('Y')); ?>

    </footer>

</body>
</html>
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/shop/show.blade.php ENDPATH**/ ?>