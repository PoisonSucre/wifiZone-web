<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>Vérifiez votre adresse email</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
    <style>
        body, table, td, a { -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; }
        table, td { mso-table-lspace:0pt; mso-table-rspace:0pt; }
        img { -ms-interpolation-mode:bicubic; border:0; outline:none; text-decoration:none; }
        body { margin:0; padding:0; width:100%!important; height:100%!important; }

        @media only screen and (max-width:600px){
            .email-wrapper { padding:24px 12px!important; }
            .email-card { border-radius:12px!important; }
            .email-padding { padding:28px 22px!important; }
            .email-header { padding:26px 22px!important; }
            .email-footer { padding:22px!important; }
            .cta-button { display:block!important; width:100%!important; box-sizing:border-box; }
            .h2-title { font-size:19px!important; }
        }
    </style>
</head>
<body style="margin:0;padding:0;background-color:#eef1f5;font-family:'Segoe UI',Roboto,Helvetica,Arial,sans-serif;">

    <!-- Preheader (hidden preview text in inbox) -->
    <div style="display:none;max-height:0;overflow:hidden;mso-hide:all;opacity:0;">
        Votre inscription a bien été enregistrée&nbsp;! Plus qu'une étape&nbsp;: confirmez votre adresse email pour activer votre compte <?php echo e(config('platform.name')); ?>.
    </div>
    <div style="display:none;max-height:0;overflow:hidden;mso-hide:all;">
        &#8199;&#8203;&#8199;&#8203;&#8199;&#8203;&#8199;&#8203;&#8199;&#8203;&#8199;&#8203;&#8199;&#8203;
    </div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#eef1f5;">
        <tr>
            <td class="email-wrapper" align="center" style="padding:48px 20px;">

                <table role="presentation" width="600" cellpadding="0" cellspacing="0" class="email-card" style="width:600px;max-width:600px;background-color:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(15,23,42,0.06);">

                    <!-- Header / Brand -->
                    <tr>
                        <td class="email-header" style="background:linear-gradient(135deg,#0d9488,#059669);padding:32px 40px;text-align:center;">
                            <table role="presentation" cellpadding="0" cellspacing="0" align="center" style="margin:0 auto;">
                                <tr>
                                    <td style="vertical-align:middle;padding-right:10px;">
                                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:block;">
                                            <path d="M12 20.5C12.8284 20.5 13.5 19.8284 13.5 19C13.5 18.1716 12.8284 17.5 12 17.5C11.1716 17.5 10.5 18.1716 10.5 19C10.5 19.8284 11.1716 20.5 12 20.5Z" fill="#ffffff"/>
                                            <path d="M8.5 15.5C10.5 13.7 13.5 13.7 15.5 15.5" stroke="#ffffff" stroke-width="1.8" stroke-linecap="round"/>
                                            <path d="M5.5 11.8C9.2 8.4 14.8 8.4 18.5 11.8" stroke="#ffffff" stroke-width="1.8" stroke-linecap="round" opacity="0.85"/>
                                            <path d="M2.5 8.2C7.9 3.4 16.1 3.4 21.5 8.2" stroke="#ffffff" stroke-width="1.8" stroke-linecap="round" opacity="0.6"/>
                                        </svg>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <span style="color:#ffffff;font-size:20px;font-weight:700;letter-spacing:0.2px;"><?php echo e(config('platform.name')); ?></span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td class="email-padding" style="padding:44px 44px 36px;">

                            <div style="text-align:center;margin-bottom:26px;">
                                <table role="presentation" cellpadding="0" cellspacing="0" align="center">
                                    <tr>
                                        <td width="64" height="64" align="center" valign="middle" style="background-color:#e6f7f2;border-radius:50%;">
                                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M3 6.5L11.35 12.7C11.7343 12.9857 12.2657 12.9857 12.65 12.7L21 6.5" stroke="#059669" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                <rect x="3" y="5" width="18" height="14" rx="2.2" stroke="#059669" stroke-width="1.8"/>
                                            </svg>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <h1 class="h2-title" style="margin:0 0 14px;color:#0f172a;font-size:21px;font-weight:700;text-align:center;line-height:1.3;">
                                Inscription reçue — Confirmez votre email
                            </h1>

                            <p style="margin:0 0 22px;color:#475569;font-size:15px;line-height:1.7;text-align:center;">
                                Bonjour <strong style="color:#0f172a;"><?php echo e($vendeur->prenom); ?> <?php echo e($vendeur->nom); ?></strong>,<br>
                                votre inscription en tant que <strong>vendeur</strong> sur <strong><?php echo e(config('platform.name')); ?></strong> a bien été enregistrée.
                            </p>

                            <p style="margin:0 0 22px;color:#475569;font-size:15px;line-height:1.7;text-align:center;">
                                Plus qu'une étape&nbsp;: confirmez votre adresse email pour <strong>activer votre compte</strong> et accéder à votre tableau de bord.
                            </p>

                            <table role="presentation" cellpadding="0" cellspacing="0" align="center" style="margin:0 auto 20px;">
                                <tr>
                                    <td align="center" style="border-radius:10px;background-color:#059669;">
                                        <a href="<?php echo e($verificationUrl); ?>" class="cta-button" style="display:inline-block;padding:15px 44px;color:#ffffff;font-size:15px;font-weight:600;text-decoration:none;border-radius:10px;">
                                            Vérifier mon adresse email
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0 0 30px;color:#94a3b8;font-size:13px;text-align:center;">
                                Ce lien de vérification expire dans 30 minutes.
                            </p>

                        </td>
                    </tr>

                    <!-- Security notice -->
                    <tr>
                        <td style="padding:0 44px 36px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8fafc;border-radius:10px;">
                                <tr>
                                    <td style="padding:16px 20px;">
                                        <p style="margin:0;color:#94a3b8;font-size:12.5px;line-height:1.6;text-align:center;">
                                            🔒 Vous n'êtes pas à l'origine de cette inscription&nbsp;? Ignorez simplement cet email, aucun compte ne sera créé.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td class="email-footer" style="background-color:#f8fafc;padding:26px 40px;text-align:center;border-top:1px solid #e5e7eb;">
                            <p style="margin:0 0 6px;color:#64748b;font-size:12.5px;font-weight:600;">
                                <?php echo e(config('platform.name')); ?>

                            </p>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(config('platform.support_email')): ?>
                            <p style="margin:0 0 12px;color:#94a3b8;font-size:11.5px;">
                                Besoin d'aide&nbsp;? <a href="mailto:<?php echo e(config('platform.support_email')); ?>" style="color:#059669;text-decoration:none;">Contactez le support</a>
                            </p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <p style="margin:0;color:#b6bec9;font-size:11px;">
                                &copy; <?php echo e(date('Y')); ?> <?php echo e(config('platform.name')); ?> — Tous droits réservés.
                            </p>
                        </td>
                    </tr>

                </table>

                <p style="margin:20px 0 0;color:#a3adba;font-size:11px;text-align:center;">
                    Cet email a été envoyé automatiquement, merci de ne pas y répondre directement.
                </p>

            </td>
        </tr>
    </table>

</body>
</html>
<?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/emails/email-verification.blade.php ENDPATH**/ ?>