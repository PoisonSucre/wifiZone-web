@extends('layouts.public')

@section('title', 'Merci - ' . config('platform.name'))

@section('content')
<div style="display:flex;align-items:center;justify-content:center;min-height:80vh;padding:20px;">
    @if($ticket ?? null)
    <div class="card" style="max-width:400px;width:100%;text-align:center;">
        <h2 style="color:#1ca04e;margin-bottom:5px;"><i class="fas fa-check-circle"></i> Merci !</h2>
        @if($vendeur_info ?? null)
        <div style="color:#999;font-size:0.9em;margin-bottom:20px;">Vendeur : {{ $vendeur_info['prenom'] ?? '' }} {{ $vendeur_info['nom'] ?? '' }}</div>
        @endif

        <div class="ticket-detail" style="background:#f8f9fa;border-radius:10px;padding:15px;margin:10px 0;text-align:left;">
            <div style="display:flex;justify-content:space-between;padding:5px 0;border-bottom:1px solid #eee;">
                <span style="color:#999;">Utilisateur</span>
                <span style="font-weight:700;color:#1a1a2e;">{{ $ticket->user }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;padding:5px 0;border-bottom:1px solid #eee;">
                <span style="color:#999;">Mot de passe</span>
                <span style="font-weight:700;">
                    <span class="pw-text" data-pw="{{ $ticket->password }}" id="tkPass">***</span>
                    <button type="button" class="toggle-pw" onclick="togglePw(this)" style="background:none;border:none;cursor:pointer;color:#1ca04e;font-size:1.1em;vertical-align:middle;"><i class="fas fa-eye"></i></button>
                </span>
            </div>
            <div style="display:flex;justify-content:space-between;padding:5px 0;border-bottom:1px solid #eee;">
                <span style="color:#999;">Forfait</span>
                <span style="font-weight:700;">{{ $ticket->forfait }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;padding:5px 0;">
                <span style="color:#999;">Montant</span>
                <span style="font-weight:700;">{{ number_format($ticket->montant ?? 0) }} {{ config('platform.currency', 'XOF') }}</span>
            </div>
        </div>

        <button class="btn btn-success" style="width:100%;margin-top:15px;" onclick="redirectToMikroTik('{{ $ticket->user }}', '{{ $ticket->password }}')">
            <i class="fas fa-wifi"></i> Se connecter au WiFi
        </button>

        <button class="btn" style="width:100%;margin-top:10px;background:#3498db;" onclick="downloadPDF()">
            <i class="fas fa-download"></i> Télécharger en PDF
        </button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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
    function redirectToMikroTik(user, password) {
        window.location.href = "{{ url('/') }}/index.php?username=" + encodeURIComponent(user) + "&password=" + encodeURIComponent(password);
    }
    function downloadPDF() {
        var pw = document.getElementById('tkPass').dataset.pw;
        var user = '{{ $ticket->user }}';
        var forfait = '{{ $ticket->forfait }}';
        var montant = '{{ number_format($ticket->montant ?? 0) }} {{ config("platform.currency", "XOF") }}';
        var { jsPDF } = window.jspdf;
        var doc = new jsPDF();
        doc.setFontSize(20);
        doc.text("{{ config('platform.name') }}", 105, 20, { align: 'center' });
        doc.setFontSize(14);
        doc.text("Votre Ticket WiFi", 105, 35, { align: 'center' });
        doc.setFontSize(12);
        doc.text("Utilisateur : " + user, 20, 55);
        doc.text("Mot de passe : " + pw, 20, 65);
        doc.text("Forfait : " + forfait, 20, 75);
        doc.text("Montant : " + montant, 20, 85);
        doc.text("En cas de besoin : 66-63-59-58 / 64-65-86-44", 105, 105, { align: 'center' });
        doc.save('ticket_wifi.pdf');
    }
    </script>

    @else
    <div class="card" style="max-width:400px;width:100%;text-align:center;">
        <h2 style="color:#1ca04e;margin-bottom:5px;"><i class="fas fa-info-circle"></i> Paiement Reçu</h2>
        <p class="no-ticket">
            @if($token ?? null)
                Votre paiement a été reçu. En attente de validation...
            @else
                Aucune transaction trouvée.
            @endif
        </p>
        @if($token ?? null)
        <div class="token-display">Token : {{ $token }}</div>
        @endif
        <p style="color:#666;font-size:0.9em;margin:15px 0;">
            En cas de problème, appelez le : <strong>66-63-59-58 / 64-65-86-44</strong>
        </p>
        <a href="{{ url('/') }}" class="btn" style="background:#666;display:block;text-decoration:none;text-align:center;">
            <i class="fas fa-home"></i> Retour à l'accueil
        </a>
    </div>
    @endif
</div>
@endsection
