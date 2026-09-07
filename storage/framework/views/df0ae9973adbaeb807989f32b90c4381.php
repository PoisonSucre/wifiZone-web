<?php
    $flashSuccess = session('success');
    $flashError = session('error');
    $flashWarning = session('warning');
    $flashInfo = session('info');
    $validationErrors = $errors->any() ? $errors->first() : null;
?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($flashSuccess || $flashError || $flashWarning || $flashInfo || $validationErrors): ?>
<script>
    (function() {
        var toasts = [];
        <?php if($flashSuccess): ?>
            toasts.push({ type: 'success', message: <?php echo json_encode($flashSuccess, 15, 512) ?> });
        <?php endif; ?>
        <?php if($flashError): ?>
            toasts.push({ type: 'error', message: <?php echo json_encode($flashError, 15, 512) ?> });
        <?php endif; ?>
        <?php if($flashWarning): ?>
            toasts.push({ type: 'warning', message: <?php echo json_encode($flashWarning, 15, 512) ?> });
        <?php endif; ?>
        <?php if($flashInfo): ?>
            toasts.push({ type: 'info', message: <?php echo json_encode($flashInfo, 15, 512) ?> });
        <?php endif; ?>
        <?php if($validationErrors): ?>
            toasts.push({ type: 'error', message: <?php echo json_encode($validationErrors, 15, 512) ?> });
        <?php endif; ?>

        function dispatchToasts() {
            toasts.forEach(function(t) {
                window.dispatchEvent(new CustomEvent('toast', { detail: t }));
            });
        }

        // Dispatch immédiatement + retry au cas où Alpine n'est pas encore prêt
        dispatchToasts();
        document.addEventListener('alpine:initialized', dispatchToasts);
        document.addEventListener('DOMContentLoaded', dispatchToasts);
        setTimeout(dispatchToasts, 100);
        setTimeout(dispatchToasts, 500);
    })();
</script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/components/flash-toast.blade.php ENDPATH**/ ?>