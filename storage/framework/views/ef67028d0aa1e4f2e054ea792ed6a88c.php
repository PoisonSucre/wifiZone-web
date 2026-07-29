<!DOCTYPE html>
<html>
<head>
    <title>Nouveau Vendeur Inscrit</title>
</head>
<body>
    <h1>Un nouveau vendeur s'est inscrit</h1>
    <p>Bonjour,</p>
    <p>Un nouveau vendeur vient de s'inscrire sur la plateforme et attend votre validation :</p>
    <ul>
        <li><strong>Nom :</strong> <?php echo e($vendeur->prenom); ?> <?php echo e($vendeur->nom); ?></li>
        <li><strong>Email :</strong> <?php echo e($vendeur->email); ?></li>
        <li><strong>Téléphone :</strong> <?php echo e($vendeur->telephone); ?></li>
    </ul>
    <p>Vous pouvez l'approuver depuis votre tableau de bord administrateur.</p>
    <br>
    <p>Cordialement,<br><?php echo e(config('platform.name')); ?></p>
</body>
</html><?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/emails/admin-vendor-registered.blade.php ENDPATH**/ ?>