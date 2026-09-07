@php
    $flashSuccess = session('success');
    $flashError = session('error');
    $flashWarning = session('warning');
    $flashInfo = session('info');
    $validationErrors = $errors->any() ? $errors->first() : null;
@endphp

@if($flashSuccess || $flashError || $flashWarning || $flashInfo || $validationErrors)
<script>
    (function() {
        var toasts = [];
        @if($flashSuccess)
            toasts.push({ type: 'success', message: @json($flashSuccess) });
        @endif
        @if($flashError)
            toasts.push({ type: 'error', message: @json($flashError) });
        @endif
        @if($flashWarning)
            toasts.push({ type: 'warning', message: @json($flashWarning) });
        @endif
        @if($flashInfo)
            toasts.push({ type: 'info', message: @json($flashInfo) });
        @endif
        @if($validationErrors)
            toasts.push({ type: 'error', message: @json($validationErrors) });
        @endif

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
@endif
