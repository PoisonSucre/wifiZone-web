<?php
    $flashSuccess = session('success');
    $flashError = session('error');
    $flashWarning = session('warning');
    $flashInfo = session('info');
    $validationErrors = $errors->any() ? $errors->first() : null;
?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($flashSuccess || $flashError || $flashWarning || $flashInfo || $validationErrors): ?>
<script>
    document.addEventListener('alpine:init', () => {
        <?php if($flashSuccess): ?>
            window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', message: <?php echo json_encode($flashSuccess, 15, 512) ?> } }));
        <?php endif; ?>
        <?php if($flashError): ?>
            window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', message: <?php echo json_encode($flashError, 15, 512) ?> } }));
        <?php endif; ?>
        <?php if($flashWarning): ?>
            window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'warning', message: <?php echo json_encode($flashWarning, 15, 512) ?> } }));
        <?php endif; ?>
        <?php if($flashInfo): ?>
            window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'info', message: <?php echo json_encode($flashInfo, 15, 512) ?> } }));
        <?php endif; ?>
        <?php if($validationErrors): ?>
            window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', message: <?php echo json_encode($validationErrors, 15, 512) ?> } }));
        <?php endif; ?>
    });
</script>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/components/flash-toast.blade.php ENDPATH**/ ?>