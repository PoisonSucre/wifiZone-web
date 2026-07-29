<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle demande de retrait</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f7fa;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f7fa;padding:40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,0.08);">
                    <tr>
                        <td style="background:linear-gradient(135deg,#f59e0b,#d97706);padding:30px 40px;text-align:center;">
                            <h1 style="margin:0;color:#ffffff;font-size:22px;font-weight:800;">
                                <i class="fas fa-wifi" style="margin-right:8px;"></i> <?php echo e(config('platform.name')); ?>

                            </h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:40px;">
                            <div style="text-align:center;margin-bottom:30px;">
                                <div style="width:70px;height:70px;background-color:#fef3c7;border-radius:50%;margin:0 auto 20px;line-height:70px;font-size:30px;">💸</div>
                            </div>
                            <h2 style="margin:0 0 15px;color:#1a1a2e;font-size:20px;text-align:center;">Nouvelle demande de retrait</h2>
                            <p style="margin:0 0 20px;color:#555;font-size:15px;line-height:1.7;text-align:center;">
                                <strong><?php echo e($vendeur->prenom); ?> <?php echo e($vendeur->nom); ?></strong> a soumis une demande de retrait.
                            </p>
                            <div style="background-color:#fffbeb;border:1px solid #fde68a;border-radius:10px;padding:20px;margin-bottom:25px;">
                                <p style="margin:0 0 8px;color:#92400e;font-size:14px;font-weight:700;">Détails :</p>
                                <p style="margin:0;color:#92400e;font-size:13px;line-height:1.8;">
                                    Montant brut : <strong><?php echo e(number_format($withdrawal->montant_brut, 0, ',', ' ')); ?> <?php echo e(config('platform.currency')); ?></strong><br>
                                    Commission (<?php echo e($withdrawal->commission_pct); ?>%) : <strong><?php echo e(number_format($withdrawal->montant_commission, 0, ',', ' ')); ?> <?php echo e(config('platform.currency')); ?></strong><br>
                                    Montant net : <strong><?php echo e(number_format($withdrawal->montant_net, 0, ',', ' ')); ?> <?php echo e(config('platform.currency')); ?></strong><br>
                                    Téléphone : <strong><?php echo e($withdrawal->phone_number); ?></strong>
                                </p>
                            </div>
                            <div style="text-align:center;margin-bottom:20px;">
                                <a href="<?php echo e(url('/raider/retraits')); ?>" style="display:inline-block;background-color:#f59e0b;color:#ffffff;font-weight:700;font-size:15px;padding:14px 36px;border-radius:50px;text-decoration:none;box-shadow:0 4px 14px rgba(245,158,11,0.4);">
                                    Traiter la demande
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
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/emails/withdrawal-requested.blade.php ENDPATH**/ ?>