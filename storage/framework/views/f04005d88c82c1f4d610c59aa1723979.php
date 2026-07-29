<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retrait approuvé</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f7fa;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f7fa;padding:40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.08);">
                    <tr>
                        <td style="background:linear-gradient(135deg,#10B981,#059669);padding:30px 40px;text-align:center;">
                            <h1 style="margin:0;color:#ffffff;font-size:22px;font-weight:800;">
                                <i class="fas fa-wifi" style="margin-right:8px;"></i> <?php echo e(config('platform.name')); ?>

                            </h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:40px;">
                            <div style="text-align:center;margin-bottom:30px;">
                                <div style="width:70px;height:70px;background-color:#d1fae5;border-radius:50%;margin:0 auto 20px;line-height:70px;font-size:30px;">✓</div>
                            </div>
                            <h2 style="margin:0 0 15px;color:#1a1a2e;font-size:20px;text-align:center;">Retrait approuvé</h2>
                            <p style="margin:0 0 20px;color:#555;font-size:15px;line-height:1.7;text-align:center;">
                                Bonjour <strong><?php echo e($vendeur->prenom); ?> <?php echo e($vendeur->nom); ?></strong>,
                            </p>
                            <p style="margin:0 0 20px;color:#555;font-size:15px;line-height:1.7;text-align:center;">
                                Votre demande de retrait de <strong style="color:#10B981;"><?php echo e(number_format($withdrawal->montant_net, 0, ',', ' ')); ?> <?php echo e(config('platform.currency')); ?></strong> a été approuvée. Le versement sera effectué prochainement.
                            </p>
                            <div style="text-align:center;margin-bottom:20px;">
                                <a href="<?php echo e(url('/vendeur/retraits')); ?>" style="display:inline-block;background-color:#10B981;color:#ffffff;font-weight:700;font-size:15px;padding:14px 36px;border-radius:50px;text-decoration:none;box-shadow:0 4px 14px rgba(16,185,129,0.4);">
                                    Voir mes retraits
                                </a>
                            </div>
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
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/emails/withdrawal-approved.blade.php ENDPATH**/ ?>