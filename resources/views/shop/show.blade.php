<!DOCTYPE html>
<html lang="fr" class="scroll-smooth {{ $themeClass }}">
<head>
    <script>(function(){var t=localStorage.getItem('theme')||document.cookie.match(/theme=([^;]+)/)?.[1]||'light';if(t==='dark')document.documentElement.classList.add('dark');})();</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <title>{{ $vendeur->prenom ?? '' }} {{ $vendeur->nom ?? '' }} - {{ config('platform.name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif; background: #f5f6fa; min-height: 100vh; display: flex; flex-direction: column; }
        .hero { background: linear-gradient(135deg, {{ $vendeur->couleur ?? '#1ca04e' }}, {{ $vendeur->couleur ?? '#1ca04e' }}cc); color: white; text-align: center; padding: 30px 15px 25px; }
        .hero h1 { font-size: 1.3em; margin-bottom: 8px; }
        .hero h1 i { margin-right: 6px; }
        .hero p { font-size: 0.9em; opacity: 0.9; }
        .hero .logo { max-width: 90px; max-height: 60px; border-radius: 10px; margin-bottom: 10px; display: block; margin-left: auto; margin-right: auto; }
        .hero .message { max-width: 500px; margin: 10px auto 0; font-size: 0.85em; opacity: 0.85; line-height: 1.5; }
        .tarifs { max-width: 800px; margin: 0 auto; padding: 20px 15px; }
        .tarifs h2 { text-align: center; color: #1a1a2e; margin-bottom: 15px; font-size: 1.1em; }
        .tarifs h2 i { color: {{ $vendeur->couleur ?? '#1ca04e' }}; margin-right: 6px; }
        .tarif-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 12px; }
        .tarif-card { background: white; border-radius: 12px; padding: 15px 10px; text-align: center; box-shadow: 0 3px 15px rgba(0,0,0,0.08); transition: transform 0.2s; border-top: 4px solid {{ $vendeur->couleur ?? '#1ca04e' }}; }
        .tarif-card:hover { transform: translateY(-3px); }
        .tarif-card .duration { font-size: 0.95em; font-weight: 700; color: #1a1a2e; margin-bottom: 6px; }
        .tarif-card .price { font-size: 1.5em; font-weight: 800; color: {{ $vendeur->couleur ?? '#1ca04e' }}; }
        .tarif-card .currency { font-size: 0.75em; color: #999; margin-bottom: 10px; }
        .tarif-card .btn-payer { display: inline-block; background: {{ $vendeur->couleur ?? '#1ca04e' }}; color: white; border: none; border-radius: 20px; padding: 7px 16px; font-weight: 700; cursor: pointer; text-decoration: none; font-size: 0.8em; transition: opacity 0.2s; }
        .tarif-card .btn-payer:hover { opacity: 0.85; }
        .tarif-card .btn-payer i { margin-right: 4px; }
        .extra { text-align: center; padding: 20px 15px; }
        .extra a { color: {{ $vendeur->couleur ?? '#1ca04e' }}; font-weight: 700; text-decoration: none; }
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
        @if($vendeur->logo)
            <img src="{{ asset($vendeur->logo) }}" alt="Logo" class="logo">
        @endif
        <h1><i class="fas fa-wifi"></i> {{ $vendeur->prenom ?? '' }} {{ $vendeur->nom ?? '' }}</h1>
        <p>{{ config('platform.name') }}</p>
        @if($vendeur->message_bienvenue)
            <div class="message">{{ $vendeur->message_bienvenue }}</div>
        @endif
    </div>

    <div class="tarifs">
        <h2><i class="fas fa-tags"></i> Forfaits disponibles</h2>
        <div class="tarif-grid">
            @forelse($forfaits as $forfait)
            <div class="tarif-card">
                <div class="duration">{{ $forfait->label }}</div>
                <div class="price">{{ number_format($forfait->montant) }}</div>
                <div class="currency">{{ config('platform.currency', 'XOF') }}</div>
                <form action="{{ url('/api/payment-process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="vendeur_id" value="{{ $vendeur->id }}">
                    <input type="hidden" name="montant" value="{{ $forfait->montant }}">
                    <input type="hidden" name="forfait" value="{{ $forfait->label }}">
                    <button type="submit" class="btn-payer"><i class="fas fa-shopping-cart"></i> Payer</button>
                </form>
            </div>
            @empty
            <div class="no-forfaits" style="grid-column: 1/-1;">
                <i class="fas fa-info-circle"></i> Aucun forfait disponible pour le moment.
            </div>
            @endforelse
        </div>
    </div>

    <div class="extra">
        <a href="{{ url('/') }}"><i class="fas fa-arrow-left"></i> Retour à l'accueil</a>
    </div>

    <footer>
        <i class="fas fa-wifi" style="color:{{ $vendeur->couleur ?? '#1ca04e' }};"></i>
        {{ config('platform.name') }} &copy; {{ date('Y') }}
    </footer>

</body>
</html>
