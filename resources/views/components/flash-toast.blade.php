@php
    $flashSuccess = session('success');
    $flashError = session('error');
    $flashWarning = session('warning');
    $flashInfo = session('info');
    $validationErrors = $errors->any() ? $errors->first() : null;
@endphp

@if($flashSuccess || $flashError || $flashWarning || $flashInfo || $validationErrors)
<script>
    document.addEventListener('alpine:init', () => {
        @if($flashSuccess)
            window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', message: @json($flashSuccess) } }));
        @endif
        @if($flashError)
            window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', message: @json($flashError) } }));
        @endif
        @if($flashWarning)
            window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'warning', message: @json($flashWarning) } }));
        @endif
        @if($flashInfo)
            window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'info', message: @json($flashInfo) } }));
        @endif
        @if($validationErrors)
            window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', message: @json($validationErrors) } }));
        @endif
    });
</script>
@endif
