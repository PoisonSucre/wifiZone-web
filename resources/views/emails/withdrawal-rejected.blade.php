<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retrait rejeté</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f7fa;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f7fa;padding:40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.08);">
                    <tr>
                        <td style="background:linear-gradient(135deg,#ef4444,#dc2626);padding:30px 40px;text-align:center;">
                            <h1 style="margin:0;color:#ffffff;font-size:22px;font-weight:800;">
                                <i class="fas fa-wifi" style="margin-right:8px;"></i> {{ config('platform.name') }}
                            </h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:40px;">
                            <div style="text-align:center;margin-bottom:30px;">
                                <div style="width:70px;height:70px;background-color:#fee2e2;border-radius:50%;margin:0 auto 20px;line-height:70px;font-size:30px;">✕</div>
                            </div>
                            <h2 style="margin:0 0 15px;color:#1a1a2e;font-size:20px;text-align:center;">Retrait rejeté</h2>
                            <p style="margin:0 0 20px;color:#555;font-size:15px;line-height:1.7;text-align:center;">
                                Bonjour <strong>{{ $vendeur->prenom }} {{ $vendeur->nom }}</strong>,
                            </p>
                            <p style="margin:0 0 20px;color:#555;font-size:15px;line-height:1.7;text-align:center;">
                                Malheureusement, votre demande de retrait de <strong style="color:#ef4444;">{{ number_format($withdrawal->montant_net, 0, ',', ' ') }} {{ config('platform.currency') }}</strong> a été rejetée.
                            </p>
                            @if($withdrawal->note)
                            <div style="background-color:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:20px;margin-bottom:25px;">
                                <p style="margin:0 0 8px;color:#991b1b;font-size:14px;font-weight:700;">Motif :</p>
                                <p style="margin:0;color:#991b1b;font-size:13px;line-height:1.7;">{{ $withdrawal->note }}</p>
                            </div>
                            @endif
                            <p style="margin:0;color:#999;font-size:13px;text-align:center;line-height:1.6;">
                                Si vous avez des questions, contactez l'administrateur.
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
