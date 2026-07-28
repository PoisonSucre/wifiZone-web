<!DOCTYPE html>
<html>
<head>
    <title>Nouveau Vendeur Inscrit</title>
</head>
<body>
    <h1>Un nouveau vendeur s'est inscrit</h1>
    <p>Bonjour,</p>
    <p>Un nouveau vendeur vient de s'inscrire sur la plateforme et attend votre validation :</p>
    <ul>
        <li><strong>Nom :</strong> {{ $vendeur->prenom }} {{ $vendeur->nom }}</li>
        <li><strong>Email :</strong> {{ $vendeur->email }}</li>
        <li><strong>Téléphone :</strong> {{ $vendeur->telephone }}</li>
    </ul>
    <p>Vous pouvez l'approuver depuis votre tableau de bord administrateur.</p>
    <br>
    <p>Cordialement,<br>{{ config('platform.name') }}</p>
</body>
</html>