Inscription reçue — Confirmez votre email

Bonjour {{ $vendeur->prenom }} {{ $vendeur->nom }},

Votre inscription en tant que vendeur sur {{ config('platform.name') }} a bien été enregistrée.

Plus qu'une étape : confirmez votre adresse email pour activer votre compte et accéder à votre tableau de bord.

Cliquez sur le lien suivant pour vérifier votre adresse email :
{{ $verificationUrl }}

Ce lien de vérification expire dans 30 minutes.

Vous n'êtes pas à l'origine de cette inscription ? Ignorez simplement cet email, aucun compte ne sera créé.

{{ config('platform.name') }}
@if(config('platform.support_email'))
Besoin d'aide ? Contactez le support : {{ config('platform.support_email') }}
@endif

© {{ date('Y') }} {{ config('platform.name') }} — Tous droits réservés.
