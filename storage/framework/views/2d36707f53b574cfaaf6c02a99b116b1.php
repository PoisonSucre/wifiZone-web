<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f7fa;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f7fa;padding:40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.08);">
                    <tr>
                        <td style="background:linear-gradient(135deg,#3b82f6,#2563eb);padding:30px 40px;text-align:center;">
                            <h1 style="margin:0;color:#ffffff;font-size:22px;font-weight:800;">
                                <i class="fas fa-wifi" style="margin-right:8px;"></i> <?php echo e(config('platform.name')); ?>

                            </h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:40px;">
                            <h2 style="margin:0 0 15px;color:#1a1a2e;font-size:20px;text-align:center;">Réinitialisation du mot de passe</h2>
                            <p style="margin:0 0 20px;color:#555;font-size:15px;line-height:1.7;text-align:center;">
                                Bonjour <strong><?php echo e($vendeur->prenom); ?> <?php echo e($vendeur->nom); ?></strong>,
                            </p>
                            <p style="margin:0 0 30px;color:#555;font-size:15px;line-height:1.7;text-align:center;">
                                Vous avez demandé la réinitialisation de votre mot de passe. Cliquez sur le bouton ci-dessous pour créer un nouveau mot de passe.
                            </p>
                            <div style="text-align:center;margin-bottom:30px;">
                                <a href="<?php echo e($resetUrl); ?>" style="display:inline-block;background-color:#3b82f6;color:#ffffff;font-weight:700;font-size:15px;padding:14px 36px;border-radius:50px;text-decoration:none;box-shadow:0 4px 14px rgba(59,130,246,0.4);">
                                    Réinitialiser mon mot de passe
                                </a>
                            </div>
                            <p style="margin:0 0 15px;color:#999;font-size:13px;text-align:center;line-height:1.6;">
                                Ce lien expire dans 60 minutes.
                            </p>
                            <p style="margin:0;color:#999;font-size:13px;text-align:center;line-height:1.6;">
                                Si vous n'avez pas fait cette demande, ignorez simplement cet email.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#f8fafc;padding:20px 40px;text-align:center;border-top:1px solid #e5e7eb;">
                            <p style="margin:0;color:#999;font-size:11px;">
                                Designed by Raider Corporation &copy; <?php echo e(date('Y')); ?>. Tous droits réservés.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/emails/reset-password.blade.php ENDPATH**/ ?>