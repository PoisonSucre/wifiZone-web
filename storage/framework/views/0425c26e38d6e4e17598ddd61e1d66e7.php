Inscription reçue — Confirmez votre email

Bonjour <?php echo e($vendeur->prenom); ?> <?php echo e($vendeur->nom); ?>,

Votre inscription en tant que vendeur sur <?php echo e(config('platform.name')); ?> a bien été enregistrée.

Plus qu'une étape : confirmez votre adresse email pour activer votre compte et accéder à votre tableau de bord.

Cliquez sur le lien suivant pour vérifier votre adresse email :
<?php echo e($verificationUrl); ?>


Ce lien de vérification expire dans 30 minutes.

Vous n'êtes pas à l'origine de cette inscription ? Ignorez simplement cet email, aucun compte ne sera créé.

<?php echo e(config('platform.name')); ?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(config('platform.support_email')): ?>
Besoin d'aide ? Contactez le support : <?php echo e(config('platform.support_email')); ?>

<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

© <?php echo e(date('Y')); ?> <?php echo e(config('platform.name')); ?> — Tous droits réservés.
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/emails/email-verification-text.blade.php ENDPATH**/ ?>