@extends('layouts.public')

@section('title', 'Récupérer un Ticket - ' . config('platform.name'))

@section('content')
<div style="display:flex;align-items:center;justify-content:center;min-height:80vh;padding:20px;">
    <div class="card" style="max-width:450px;width:100%;">
        <h2 style="text-align:center;"><i class="fas fa-ticket-alt"></i> Récupérer un Ticket</h2>

        <form method="GET" style="margin-bottom:20px;">
            <div class="form-group">
                <label>Token de paiement</label>
                <input type="text" name="token" placeholder="Collez votre token ici" value="{{ $token ?? '' }}">
            </div>
            <button type="submit" class="btn btn-success" style="width:100%;">
                <i class="fas fa-search"></i> Récupérer
            </button>
        </form>

        @if(($message ?? '') === 'success' && ($ticket ?? null))
        <div style="background:#e8f5e9;border-radius:10px;padding:15px;">
            <p style="text-align:center;color:#2e7d32;font-weight:700;margin-bottom:10px;">
                <i class="fas fa-check-circle"></i> Ticket trouvé !
            </p>
            <div style="background:white;border-radius:8px;padding:15px;">
                <div style="display:flex;justify-content:space-between;padding:5px 0;border-bottom:1px solid #eee;"><span style="color:#999;">Utilisateur</span><span style="font-weight:700;">{{ $ticket->user }}</span></div>
                <div style="display:flex;justify-content:space-between;padding:5px 0;border-bottom:1px solid #eee;"><span style="color:#999;">Mot de passe</span><span style="font-weight:700;"><span class="pw-text" data-pw="{{ $ticket->password }}">***</span> <button type="button" class="toggle-pw" onclick="togglePw(this)" style="background:none;border:none;cursor:pointer;color:#1ca04e;font-size:1.1em;vertical-align:middle;"><i class="fas fa-eye"></i></button></span></div>
                <div style="display:flex;justify-content:space-between;padding:5px 0;border-bottom:1px solid #eee;"><span style="color:#999;">Forfait</span><span style="font-weight:700;">{{ $ticket->forfait }}</span></div>
                <div style="display:flex;justify-content:space-between;padding:5px 0;"><span style="color:#999;">Vendeur</span><span style="font-weight:700;">{{ $ticket->prenom ?? '' }} {{ $ticket->nom ?? '' }}</span></div>
            </div>
        </div>
        @elseif(($message ?? '') === 'not_found')
        <div style="background:#fee;border-radius:10px;padding:15px;text-align:center;color:#c0392b;">
            <i class="fas fa-exclamation-circle"></i> Ticket introuvable ou déjà utilisé.
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function togglePw(btn) {
    const span = btn.closest('span').querySelector('.pw-text');
    const icon = btn.querySelector('i');
    if (span.textContent === '***') {
        span.textContent = span.dataset.pw;
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        span.textContent = '***';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
@endpush
@endsection
