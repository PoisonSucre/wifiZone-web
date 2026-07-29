@if(!($embed ?? false))<!DOCTYPE html>
<html>
<head>
    <title>{{ $vendeur->nom_portail ?? ($vendeur->prenom ?? '') . ' ' . ($vendeur->nom ?? '') }} - WiFi</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="theme-color" content="{{ $vendeur->couleur ?? '#1ca04e' }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
@endif
    <style>
@if(!($embed ?? false))
body {
    font-family: -apple-system, BlinkMacSystemFont, "segoe ui", Verdana, Roboto, "helvetica neue", Arial, sans-serif, "apple color emoji";
    font-size: 14px;
    margin: 0;
}
@endif
.main {
    background: linear-gradient(to bottom, {{ $vendeur->couleur_top ?? '#110904' }}cb, {{ $vendeur->couleur ?? '#1ca04e' }}ab);
    color: #f2f2f2;
    max-width: 300px;
    height: 100%;
    min-height: 300px;
    border-radius: 25px;
    padding: 10px;
    margin: 10% auto 0;
    text-align: center;
    animation: fadein 1s;
    transition: 0.3s;
}
#main .box { margin-bottom: 10px; text-align: center; }
#main .brand {
    color: #fff;
    margin: 10px;
    font-size: 35px;
    border-bottom: solid 2px #fff;
    border: #fff solid;
    border-radius: 25px;
    background-image: url('{{ asset("template/boom.gif") }}');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    padding: 46%;
    text-align: center;
    padding-bottom: 45px;
}
@keyframes fadein {
    from { opacity: 0; }
    to { opacity: 1; }
}
#main .nom {
    font-size: 25px;
    text-transform: uppercase;
    text-shadow: 2px 0px 3px #000;
    font-weight: bold;
    background: linear-gradient(40deg, red, #fffb01, #ff0, #48ff00);
    background-size: 200%;
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    -webkit-text-fill-color: currentColor;
    animation: snakeEffect 10s infinite linear;
}
@keyframes snakeEffect {
    0% { background-position: 200%; }
    50% { background-position: 20%; }
    100% { background-position: 200%; }
}
#main .username, #main .password {
    background: #fdfbfb;
    border: none;
    border-radius: 25px;
    text-align: center;
    font-size: 16px;
    color: #000;
    outline: none;
    width: 100%;
    height: 35px;
    margin-bottom: 5px;
}
#main .username { border-bottom: 1px solid #f2f2f2; }
#main .password { margin-bottom: 10px; border-top: 1px solid #f2f2f2; }
#main .button {
    background: #000;
    border: none;
    border-radius: 25px;
    color: #fff;
    font-weight: bold;
    display: block;
    width: 150px;
    height: 27px;
    padding: 5px 10px;
    font-size: 14px;
    margin: 0 auto 5px;
    cursor: pointer;
    animation: floating 3s ease-in-out infinite;
}
#main .button:hover {
    background: {{ $vendeur->couleur ?? '#1ca04e' }};
    font-weight: bold;
    box-shadow: 0 10px 15px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
    border-color: #000;
    transform: scale(1.05);
}
@keyframes floating {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-6px); }
}
#main .small-button {
    background: #000;
    background-image: linear-gradient(to top, #000, rgb(48,45,45));
    border: none;
    border-radius: 25px;
    color: #fff;
    font-weight: bold;
    display: inline-block;
    cursor: pointer;
    height: 30px;
    width: 82%;
    margin: 4px;
    vertical-align: middle;
    text-decoration: none;
}
#main .notice {
    background: red;
    border-radius: 3px;
    padding: 5px;
    margin-bottom: 10px;
    font-size: 14px;
    color: #fff;
}
#main table { border-collapse: separate; }
#main .table { width: 100%; }
#main .table td {
    padding: 5px;
    border: 1px solid #f2f2f2 !important;
    color: #000;
    background: #fff;
    border-radius: 25px;
}
#main .table th {
    padding: 5px;
    border: none;
    color: #fff;
    background: #000;
    border-radius: 25px;
}
#main .table td, #main th, #main a {
    color: #000;
    text-decoration: none;
    font-weight: 700;
}
#main .table td form button {
    width: 100%;
    height: 100%;
    border: 2px solid transparent;
    border-radius: 15px;
    background: transparent;
    font-weight: bold;
    color: #000;
    cursor: pointer;
    text-align: center;
    transition: all 0.3s ease;
}
#main .table td form button:hover {
    background: #000;
    color: #fff;
    border-color: #000;
    transform: scale(1.05);
}
#main .notification {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f7f7f7;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 3px;
    margin-top: 1px;
    font-size: 14px;
    color: #333;
}
#main .notification i { margin-right: 10px; }
#main .pub { font-size: 13px; font-weight: 800; }
#main .infos {
    text-shadow: 2px 2px 3px #fff;
    color: #000;
    font-weight: 600;
}
#main .blink { animation: blink 1s infinite; text-decoration: none; }
@keyframes blink {
    0% { color: red; }
    50% { color: #fff; }
    100% { color: #000; }
}
#main .password-container {
    position: relative;
    display: flex;
    align-items: center;
}
#main .password { padding-right: 30px; }
#main .password-container svg {
    position: absolute;
    color: #000;
    right: 10px;
    top: 8px;
    cursor: pointer;
}
@media (max-width: 600px) { .main { width: 90%; margin-top: 10%; } }
@media (min-width: 600px) { .main { margin-top: 2%; } }
    </style>
@if(!($embed ?? false))
</head>
<body>
@endif
    <div id="main" class="main">
        <h3 class="nom">{{ $vendeur->nom_portail ?? ($vendeur->prenom ?? '') . ' ' . ($vendeur->nom ?? '') }}</h3>

        @if($vendeur->logo)
        <div class="box">
            <img src="{{ asset($vendeur->logo) }}" style="max-width:80px;max-height:60px;border-radius:10px;display:block;margin:0 auto 10px" alt="Logo">
        </div>
        @endif

        <div class="box">
            <h3 class="brand"></h3>
            <marquee style="font-weight:600;text-shadow:2px 5px 3px #000">
                Besoin d'un Ticket : cliquez sur payer pour vous en procurer en ligne !!!
            </marquee>
        </div>

        <div class="box">
            <button class="small-button" onclick="window.location='{{ url('/recuperer-ticket') }}'">
                <i class="fas fa-ticket-alt"></i> Récupérer un ticket acheté
            </button>
        </div>

        @if(!($hideLogin ?? false))
        <div class="box">
            <button class="small-button" onclick="window.location='{{ url('/recuperer-ticket') }}'">
                <i class="fas fa-qrcode"></i> Scannez le Qrcode ici
            </button>
        </div>

        <div class="box" id="infologin"></div>
        <form autocomplete="on" name="login" action="#" method="post" onsubmit="return false">
            <input type="hidden" name="dst" value="" />
            <input type="hidden" name="popup" value="true" />
            <input class="username" id="username" name="username" type="text" placeholder="Nom d'utilisateur" required />
            <div class="password-container">
                <input class="password" id="password" name="password" type="password" placeholder="Mot de passe" required />
                <svg class="eye" onclick="togglePasswordVisibility()" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                    <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </div>
            <button class="button" type="submit">Valider</button>
        </form>
        @endif

        <table class="table" border="0" cellspacing="2" cellpadding="3">
            <span class="pub">Acheter nos tickets avec :</span>
            <div class="notification">
                <i style="background-image:url('{{ asset('template/orange.png') }}');width:70px;height:40px;display:inline-block;background-size:cover"></i>
                <i style="background-image:url('{{ asset('template/moov.png') }}');width:40px;height:40px;display:inline-block;background-size:cover"></i>
                <i style="background-image:url('{{ asset('template/wave.png') }}');width:50px;height:42px;display:inline-block;background-size:cover"></i>
            </div>
            <br />
            <caption style="font-size:16px;font-weight:800;margin-bottom:5px">Nos Tarifs</caption>
            <tr>
                <th>Forfait</th>
                <th>Prix</th>
                <th>Activer</th>
            </tr>
            @forelse($forfaits as $forfait)
            <tr>
                <td>{{ $forfait->label }}</td>
                <td>{{ number_format($forfait->montant, 0, ',', ' ') }} FCFA</td>
                <td>
                    <form action="{{ url('/api/payment-process') }}" method="POST">
                        @csrf
                        <input type="hidden" name="vendeur_id" value="{{ $vendeur->id }}" />
                        <input type="hidden" name="montant" value="{{ $forfait->montant }}" />
                        <input type="hidden" name="forfait" value="{{ $forfait->label }}" />
                        <button type="submit" class="pay-button">Payer</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align:center;color:#999">Aucun forfait disponible pour le moment.</td>
            </tr>
            @endforelse
        </table>

        <br>

        <div class="infos">
            {{ $vendeur->message_bienvenue ?? "Les tickets peuvent être achetés en contactant votre fournisseur d'accès." }}
        </div>

        <br />
        <div class="box" style="color:#000;font-weight:600">
            <i>Designed by Raider Corporation</i><br />
        </div>
    </div>

@if(!($embed ?? false))
    @if(!($hideLogin ?? false))
    <script>
        function togglePasswordVisibility() {
            var f = document.querySelector(".password");
            f.type = f.type === "password" ? "text" : "password";
        }
    </script>
    @endif
    <script>
        document.addEventListener('submit', function(e) {
            var form = e.target;
            if (form.action && form.action.indexOf('/api/payment-process') !== -1) {
                e.preventDefault();
                var formData = new FormData(form);
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (data.success && data.payment_url) {
                        window.location.href = data.payment_url;
                    } else {
                        alert('Erreur: ' + (data.error || (data.details && data.details.description) || 'Paiement impossible'));
                    }
                })
                .catch(function() { alert('Erreur de connexion au serveur de paiement'); });
            }
        });
    </script>
</body>
</html>
@endif