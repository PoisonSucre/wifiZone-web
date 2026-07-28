<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande d'inscription reçue</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f7fa;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f7fa;padding:40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.08);">
                    <tr>
                        <td style="background:linear-gradient(135deg,#3b82f6,#2563eb);padding:30px 40px;text-align:center;">
                            <h1 style="margin:0;color:#ffffff;font-size:22px;font-weight:800;">
                                {{ config('platform.name') }}
                            </h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:40px;">
                            <h2 style="margin:0 0 15px;color:#1a1a2e;font-size:20px;text-align:center;">Bonjour {{ $vendeur->prenom }} {{ $vendeur->nom }},</h2>
                            <p style="margin:0 0 20px;color:#555;font-size:15px;line-height:1.7;text-align:center;">
                                Votre demande d'inscription en tant que <strong>vendeur</strong> a bien été reçue.
                            </p>
                            <p style="margin:0 0 20px;color:#555;font-size:15px;line-height:1.7;text-align:center;">
                                Votre compte est actuellement en <strong>attente d'approbation</strong> par notre équipe. Nous examinerons votre dossier dans les plus brefs délais.
                            </p>
                            <p style="margin:0 0 30px;color:#555;font-size:15px;line-height:1.7;text-align:center;">
                                Vous recevrez une notification par email dès que votre compte sera activé.
                            </p>
                            <p style="margin:0;color:#999;font-size:13px;text-align:center;line-height:1.6;">
                                Merci pour votre confiance !
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#f8fafc;padding:20px 40px;text-align:center;border-top:1px solid #e5e7eb;">
                            <p style="margin:0;color:#999;font-size:11px;">
                                Designed by Raider Corporation &copy; {{ date('Y') }}. Tous droits réservés.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
