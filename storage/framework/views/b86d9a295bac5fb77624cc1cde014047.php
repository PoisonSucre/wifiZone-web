<?php $__env->startSection('title', 'Merci - ' . config('platform.name')); ?>

<?php $__env->startSection('content'); ?>

<?php
    // Référence décorative du ticket (stable, basée sur les données du ticket)
    $ticketRef = null;
    if ($ticket ?? null) {
        $ticketRef = $ticket->reference ?? $ticket->numero ?? $ticket->id ?? null;
        if (!$ticketRef) {
            $ticketRef = strtoupper(substr(md5(($ticket->user ?? '') . ($ticket->password ?? '')), 0, 10));
        }
    }

    // Numéros de support : ajustez ici si besoin (utilisés pour les liens tel: et WhatsApp)
    $supportCallNumber = '66 63 59 58';
    $supportWhatsapp   = '64 65 86 44';
    $supportCallTel    = '+22666635958';
    $supportWaLink     = '22664658644';
?>

<div class="ticket-page">
    <div class="ticket-stage">

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ticket ?? null): ?>
        
        <div class="ticket-3d" id="ticketCard">
            <div class="ticket-shadow-layer layer-2"></div>
            <div class="ticket-shadow-layer layer-1"></div>

            <div class="ticket-paper">
                <div class="ticket-grain" aria-hidden="true"></div>
                <div class="ticket-sheen" aria-hidden="true"></div>
                <div class="ticket-stamp">Payé</div>
                <div class="ticket-crease" aria-hidden="true"></div>

                <div class="ticket-content">
                    <div class="ticket-top">
                        <div class="ticket-brand">
                            <span class="ticket-brand-icon"><i class="fas fa-wifi"></i></span>
                            <span class="ticket-brand-name"><?php echo e(config('platform.name')); ?></span>
                        </div>
                        <div class="ticket-status"><i class="fas fa-check-circle"></i> Confirmé</div>
                    </div>

                    <div class="ticket-headline">
                        <h2>Merci pour votre achat</h2>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($vendeur_info ?? null): ?>
                        <p class="ticket-vendor">Servi par <?php echo e($vendeur_info['prenom'] ?? ''); ?> <?php echo e($vendeur_info['nom'] ?? ''); ?></p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="ticket-perforation" aria-hidden="true"></div>

                    <div class="ticket-body">
                        <div class="ticket-row">
                            <span class="ticket-label">Utilisateur</span>
                            <span class="ticket-value ticket-pw">
                                <span id="tkUser"><?php echo e($ticket->user); ?></span>
                                <button type="button" class="copy-btn" data-copy="<?php echo e($ticket->user); ?>" aria-label="Copier l'utilisateur">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </span>
                        </div>
                        <div class="ticket-row">
                            <span class="ticket-label">Mot de passe</span>
                            <span class="ticket-value ticket-pw">
                                <span class="pw-text" data-pw="<?php echo e($ticket->password); ?>" data-revealed="0" id="tkPass">••••••</span>
                                <button type="button" class="pw-toggle" id="pwToggle" aria-label="Afficher le mot de passe">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="copy-btn" data-copy="<?php echo e($ticket->password); ?>" aria-label="Copier le mot de passe">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </span>
                        </div>
                        <div class="ticket-row">
                            <span class="ticket-label">Forfait</span>
                            <span class="ticket-value"><?php echo e($ticket->forfait); ?></span>
                        </div>
                        <div class="ticket-row ticket-row-total">
                            <span class="ticket-label">Montant payé</span>
                            <span class="ticket-value ticket-amount">
                                <?php echo e(number_format($ticket->montant ?? 0)); ?> <small><?php echo e(config('platform.currency', 'XOF')); ?></small>
                            </span>
                        </div>
                        <div class="ticket-row">
                            <span class="ticket-label">Token</span>
                            <span class="ticket-value ticket-pw">
                                <span id="tkToken"><?php echo e($token); ?></span>
                                <button type="button" class="copy-btn" data-copy="<?php echo e($token); ?>" aria-label="Copier le token">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </span>
                        </div>
                    </div>

                    <div class="ticket-actions">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mikrotikUrl): ?>
                        <button type="button" class="ticket-btn ticket-btn-primary" id="btnConnect"
                                data-user="<?php echo e($ticket->user); ?>" data-password="<?php echo e($ticket->password); ?>">
                            <i class="fas fa-wifi"></i> Se connecter au WiFi
                        </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <button type="button" class="ticket-btn ticket-btn-secondary" id="btnPdf">
                            <i class="fas fa-download"></i> Télécharger en PDF
                        </button>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mikrotikUrl): ?>
                    <div id="qrcode" style="text-align:center;margin:12px 0;display:flex;justify-content:center;"></div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <div class="ticket-perforation" aria-hidden="true"></div>

                    <div class="ticket-stub">
                        <div class="ticket-stub-row">
                            <div class="ticket-barcode" aria-hidden="true"></div>
                            <div class="ticket-hologram" title="Ticket vérifié" aria-hidden="true"><i class="fas fa-shield-alt"></i></div>
                        </div>
                        <div class="ticket-stub-id">N° <?php echo e($ticketRef); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ticket-ground-shadow" id="groundShadow"></div>

        <p class="ticket-caption">Conservez ce ticket, il pourra vous être demandé en cas de besoin.</p>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
        <script>
            (function () {
                function togglePw(btn) {
                    var wrapper = btn.parentElement;
                    var span = wrapper.querySelector('.pw-text');
                    var icon = btn.querySelector('i');
                    var revealed = span.getAttribute('data-revealed') === '1';
                    if (!revealed) {
                        span.textContent = span.dataset.pw;
                        span.setAttribute('data-revealed', '1');
                        icon.classList.replace('fa-eye', 'fa-eye-slash');
                        btn.setAttribute('aria-label', 'Masquer le mot de passe');
                    } else {
                        span.textContent = '••••••';
                        span.setAttribute('data-revealed', '0');
                        icon.classList.replace('fa-eye-slash', 'fa-eye');
                        btn.setAttribute('aria-label', 'Afficher le mot de passe');
                    }
                }

                function copyToClipboard(text, btn) {
                    navigator.clipboard.writeText(text).then(function () {
                        var icon = btn.querySelector('i');
                        var original = icon.className;
                        icon.className = 'fas fa-check';
                        btn.style.color = '#1ca04e';
                        setTimeout(function () {
                            icon.className = original;
                            btn.style.color = '';
                        }, 1500);
                    }).catch(function () {
                        alert('Impossible de copier');
                    });
                }

                function downloadPDF() {
                    var pw = document.getElementById('tkPass').dataset.pw;
                    var user = <?php echo json_encode($ticket->user ?? ''); ?>;
                    var forfait = <?php echo json_encode($ticket->forfait ?? ''); ?>;
                    var montant = <?php echo json_encode(number_format($ticket->montant ?? 0) . ' ' . config('platform.currency', 'XOF')); ?>;
                    var platformName = <?php echo json_encode(config('platform.name')); ?>;
                    var token = <?php echo json_encode($token ?? ''); ?>;

                    var jsPDFCtor = window.jspdf.jsPDF;
                    var doc = new jsPDFCtor();

                    doc.setFillColor(28, 160, 78);
                    doc.rect(0, 0, 210, 32, 'F');
                    doc.setTextColor(255, 255, 255);
                    doc.setFontSize(20);
                    doc.text(platformName, 105, 16, { align: 'center' });
                    doc.setFontSize(11);
                    doc.text('Ticket WiFi', 105, 24, { align: 'center' });

                    doc.setDrawColor(226, 217, 190);
                    doc.setLineDashPattern([2, 2], 0);
                    doc.line(20, 45, 190, 45);

                    var rows = [
                        ['Utilisateur', user],
                        ['Mot de passe', pw],
                        ['Forfait', forfait],
                        ['Montant payé', montant],
                        ['Token', token]
                    ];
                    var y = 58;
                    rows.forEach(function (r) {
                        doc.setFont(undefined, 'normal');
                        doc.setTextColor(140, 133, 112);
                        doc.text(r[0], 20, y);
                        doc.setFont(undefined, 'bold');
                        doc.setTextColor(26, 26, 46);
                        doc.text(String(r[1]), 190, y, { align: 'right' });
                        y += 12;
                    });

                    doc.setDrawColor(226, 217, 190);
                    doc.setLineDashPattern([2, 2], 0);
                    doc.line(20, y + 4, 190, y + 4);

                    doc.setFontSize(10);
                    doc.setTextColor(140, 133, 112);
                    doc.text("Assistance : <?php echo e($supportCallNumber); ?> / <?php echo e($supportWhatsapp); ?>", 105, y + 16, { align: 'center' });

                    doc.save('ticket-wifi.pdf');
                }

                document.addEventListener('DOMContentLoaded', function () {
                    var pwToggle = document.getElementById('pwToggle');
                    if (pwToggle) pwToggle.addEventListener('click', function () { togglePw(pwToggle); });

                    var card = document.getElementById('ticketCard');
                    if (card) {
                        card.addEventListener('animationend', function () {
                            this.style.animation = 'none';
                        });
                    }

                    var connectBtn = document.getElementById('btnConnect');
                    if (connectBtn) {
                        connectBtn.addEventListener('click', function () {
                            var user = connectBtn.dataset.user || '';
                            var password = connectBtn.dataset.password || '';
                            window.location.href = "<?php echo e($mikrotikUrl); ?>/login.html?username=" + encodeURIComponent(user) + "&password=" + encodeURIComponent(password);
                        });
                    }

                    var pdfBtn = document.getElementById('btnPdf');
                    if (pdfBtn) pdfBtn.addEventListener('click', downloadPDF);

                    document.querySelectorAll('.copy-btn').forEach(function (btn) {
                        btn.addEventListener('click', function () {
                            copyToClipboard(btn.dataset.copy, btn);
                        });
                    });

                    var qrContainer = document.getElementById('qrcode');
                    if (qrContainer && window.QRCode) {
                        var user = <?php echo json_encode($ticket->user ?? ''); ?>;
                        var password = <?php echo json_encode($ticket->password ?? ''); ?>;
                        var loginUrl = "<?php echo e($mikrotikUrl); ?>/login.html?username=" + encodeURIComponent(user) + "&password=" + encodeURIComponent(password);
                        new QRCode(qrContainer, {
                            text: loginUrl,
                            width: 140,
                            height: 140,
                            colorDark: '#1A1A2E',
                            colorLight: '#FBF7EC',
                            correctLevel: QRCode.CorrectLevel.H
                        });
                    }
                });
            })();
        </script>

        <?php else: ?>
        
        <div class="ticket-3d" id="ticketCard">
            <div class="ticket-shadow-layer layer-2"></div>
            <div class="ticket-shadow-layer layer-1"></div>

            <div class="ticket-paper ticket-paper-pending">
                <div class="ticket-grain" aria-hidden="true"></div>

                <div class="ticket-content">
                    <div class="ticket-top">
                        <div class="ticket-brand">
                            <span class="ticket-brand-icon"><i class="fas fa-wifi"></i></span>
                            <span class="ticket-brand-name"><?php echo e(config('platform.name')); ?></span>
                        </div>
                        <div class="ticket-status pending"><i class="fas fa-clock"></i> En attente</div>
                    </div>

                    <div class="ticket-headline">
                        <h2><?php echo e(($token ?? null) ? 'Paiement reçu' : 'Ticket introuvable'); ?></h2>
                    </div>

                    <div class="ticket-perforation" aria-hidden="true"></div>

                    <div class="ticket-body-pending">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($token ?? null): ?>
                            <p>Votre paiement a été reçu. Validation en cours...</p>
                            <div class="ticket-token">Token : <?php echo e($token); ?></div>
                        <?php else: ?>
                            <p>Aucune transaction trouvée pour ce paiement.</p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <a href="<?php echo e(url('/')); ?>" class="ticket-btn ticket-btn-secondary ticket-btn-link">
                        <i class="fas fa-home"></i> Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>
        <div class="ticket-ground-shadow" id="groundShadow"></div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div class="support-card">
            <div class="support-header">
                <h3>Besoin d'aide ?</h3>
                <p>Notre équipe est disponible pour répondre à vos questions</p>
            </div>
            <div class="support-channels">
                <a href="tel:<?php echo e($supportCallTel); ?>" class="support-channel">
                    <span class="support-icon"><i class="fas fa-phone-alt"></i></span>
                    <span class="support-text">
                        <strong>Appelez-nous</strong>
                        <span><?php echo e($supportCallNumber); ?></span>
                    </span>
                    <i class="fas fa-chevron-right support-arrow"></i>
                </a>
                <a href="https://wa.me/<?php echo e($supportWaLink); ?>" target="_blank" rel="noopener noreferrer" class="support-channel whatsapp">
                    <span class="support-icon"><i class="fab fa-whatsapp"></i></span>
                    <span class="support-text">
                        <strong>WhatsApp</strong>
                        <span><?php echo e($supportWhatsapp); ?></span>
                    </span>
                    <i class="fas fa-chevron-right support-arrow"></i>
                </a>
            </div>
            <div class="support-hours">
                <i class="fas fa-clock"></i> Assistance disponible tous les jours, 7h – 22h
            </div>
        </div>

    </div>
</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Manrope:wght@500;700;800&family=JetBrains+Mono:wght@400;600;700&display=swap');

.ticket-page {
    --paper: #FBF7EC;
    --paper-dim: #F2EAD6;
    --ink: #1A1A2E;
    --muted: #8C8570;
    --line: #E3D9BE;
    --brand: #1CA04E;
    --brand-dark: #14813D;
    --amber: #B4790C;
    --amber-bg: rgba(180, 121, 12, 0.12);
    --shadow: 26, 26, 46;
    font-family: 'Manrope', -apple-system, BlinkMacSystemFont, sans-serif;
}

.ticket-stage {
    width: 100%;
    min-height: 80vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 16px;
    padding: 56px 20px;
    background: #F3F0E6;
}

/* ---------- 3D card + stacked-paper illusion ---------- */
.ticket-3d {
    position: relative;
    width: 100%;
    max-width: 380px;
    transform-style: preserve-3d;
    transition: transform .35s cubic-bezier(.2,.8,.2,1);
    animation: ticketDrop .9s cubic-bezier(.2,.8,.2,1);
    will-change: transform;
}

@keyframes ticketDrop {
    0%   { transform: rotateX(65deg) rotateY(-8deg) translateY(-50px) scale(.92); opacity: 0; }
    100% { transform: rotateX(6deg) rotateY(-8deg) rotateZ(-1deg) translateY(0) scale(1); opacity: 1; }
}

.ticket-shadow-layer {
    position: absolute;
    inset: 0;
    background: var(--paper-dim);
    border-radius: 18px;
    transform-style: preserve-3d;
}
.layer-1 { transform: translateZ(-14px) translate(6px, 10px) rotate(2deg); opacity: .85; }
.layer-2 { transform: translateZ(-28px) translate(12px, 20px) rotate(4deg); opacity: .55; }

/* soft contact shadow on the "table", shifts with tilt for parallax */
.ticket-ground-shadow {
    width: 70%;
    max-width: 250px;
    height: 22px;
    margin-top: -6px;
    background: radial-gradient(ellipse at center, rgba(26,26,46,.32), transparent 72%);
    filter: blur(5px);
    transition: transform .35s ease, opacity .35s ease;
}

.ticket-paper {
    position: relative;
    background: var(--paper);
    border-radius: 18px;
    padding: 28px 28px 20px;
    box-shadow:
        0 2px 0 rgba(255,255,255,.6) inset,
        0 34px 60px -18px rgba(var(--shadow), .38),
        0 12px 22px -10px rgba(var(--shadow), .28);
    overflow: hidden;
}

/* paper grain texture */
.ticket-grain {
    position: absolute;
    inset: 0;
    z-index: 0;
    border-radius: 18px;
    background-image:
        radial-gradient(rgba(26,26,46,.05) 1px, transparent 1px),
        radial-gradient(rgba(26,26,46,.03) 1px, transparent 1px);
    background-size: 3px 3px, 7px 7px;
    background-position: 0 0, 2px 3px;
    pointer-events: none;
}

/* faint paper fold crease across the middle */
.ticket-crease {
    position: absolute;
    left: -10%;
    right: -10%;
    top: 54%;
    height: 10px;
    z-index: 1;
    transform: rotate(-0.6deg);
    background: linear-gradient(to bottom, rgba(255,255,255,.5), rgba(26,26,46,.05));
    pointer-events: none;
}

/* glossy sheen sweep, plays once on load */
.ticket-sheen {
    position: absolute;
    top: -60%;
    left: -60%;
    width: 55%;
    height: 220%;
    z-index: 3;
    background: linear-gradient(120deg, transparent, rgba(255,255,255,.55), transparent);
    transform: rotate(18deg);
    mix-blend-mode: overlay;
    animation: sheen 3s ease-in-out .9s 1;
    pointer-events: none;
}
@keyframes sheen { 0% { left: -60%; } 100% { left: 130%; } }

/* ink stamp */
.ticket-stamp {
    position: absolute;
    top: 24px;
    right: -8px;
    z-index: 2;
    color: var(--brand-dark);
    border: 3px solid var(--brand-dark);
    border-radius: 8px;
    padding: 3px 11px;
    font-family: 'JetBrains Mono', monospace;
    font-weight: 700;
    font-size: .72rem;
    letter-spacing: 3px;
    text-transform: uppercase;
    transform: rotate(-13deg);
    opacity: .85;
    mix-blend-mode: multiply;
    animation: stampDown .5s cubic-bezier(.3,1.8,.4,1) 1.05s both;
}
@keyframes stampDown {
    0%   { transform: rotate(-13deg) scale(2.6); opacity: 0; }
    60%  { opacity: .9; }
    100% { transform: rotate(-13deg) scale(1); opacity: .85; }
}

.ticket-content { position: relative; z-index: 1; }

/* ---------- header ---------- */
.ticket-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 14px;
}
.ticket-brand {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 800;
    color: var(--ink);
    letter-spacing: .2px;
    text-shadow: 0 1px 0 rgba(255,255,255,.6);
}
.ticket-brand-icon { color: var(--brand); }
.ticket-status {
    font-size: .68rem;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: var(--brand-dark);
    background: rgba(28,160,78,.12);
    padding: 4px 10px;
    border-radius: 20px;
    white-space: nowrap;
}
.ticket-status.pending { color: var(--amber); background: var(--amber-bg); }

.ticket-headline h2 {
    margin: 0 0 2px;
    font-size: 1.25rem;
    color: var(--ink);
    font-weight: 800;
}
.ticket-vendor { color: var(--muted); font-size: .85rem; margin: 0; }

/* ---------- perforation (punched, with real depth) ---------- */
.ticket-perforation {
    position: relative;
    height: 2px;
    margin: 18px -28px;
    background-image: repeating-linear-gradient(to right, var(--line) 0 8px, transparent 8px 18px);
}
.ticket-perforation::before,
.ticket-perforation::after {
    content: "";
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: radial-gradient(circle at 35% 35%, #F7F5EC 0%, #F3F0E6 55%, #E4DFC9 100%);
    box-shadow: inset 0 1px 2px rgba(26,26,46,.25), inset 0 -1px 1px rgba(255,255,255,.5);
}
.ticket-perforation::before { left: -13px; }
.ticket-perforation::after { right: -13px; }

/* ---------- body rows ---------- */
.ticket-body { margin: 2px 0 18px; }
.ticket-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 9px 0;
    border-bottom: 1px dashed var(--line);
}
.ticket-row:last-child { border-bottom: none; }
.ticket-label {
    font-size: .7rem;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    color: var(--muted);
    font-weight: 700;
}
.ticket-value {
    font-family: 'JetBrains Mono', monospace;
    font-weight: 700;
    color: var(--ink);
    font-size: .92rem;
    text-align: right;
}
.ticket-row-total .ticket-value { color: var(--brand-dark); font-size: 1.1rem; }
.ticket-amount small { font-size: .68em; color: var(--muted); font-weight: 600; }

.ticket-pw { display: flex; align-items: center; gap: 6px; }
.pw-toggle,
.copy-btn {
    background: none;
    border: none;
    cursor: pointer;
    color: var(--brand-dark);
    font-size: 1rem;
    padding: 3px;
    line-height: 1;
    transition: color .15s ease;
}
.copy-btn { color: var(--muted); font-size: .85rem; }
.copy-btn:hover { color: var(--brand-dark); }
.pw-toggle:focus-visible,
.ticket-btn:focus-visible,
.support-channel:focus-visible {
    outline: 2px solid var(--brand-dark);
    outline-offset: 2px;
}

/* ---------- actions ---------- */
.ticket-actions { display: flex; flex-direction: column; gap: 10px; margin-bottom: 4px; }
.ticket-btn {
    border: none;
    border-radius: 12px;
    padding: 13px 16px;
    font-weight: 700;
    font-size: .93rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none;
    transition: transform .15s ease, box-shadow .15s ease;
}
.ticket-btn:active { transform: scale(.97); }
.ticket-btn-primary {
    background: linear-gradient(135deg, var(--brand), var(--brand-dark));
    color: #fff;
    box-shadow: 0 8px 16px -6px rgba(28,160,78,.5);
}
.ticket-btn-secondary {
    background: var(--paper-dim);
    color: var(--ink);
    border: 1px solid var(--line);
}
.ticket-btn-link { margin-top: 6px; }

/* ---------- stub / barcode / hologram ---------- */
.ticket-stub { padding-top: 12px; text-align: center; }
.ticket-stub-row { display: flex; align-items: center; gap: 10px; }
.ticket-barcode {
    flex: 1;
    height: 32px;
    background-image: repeating-linear-gradient(
        to right,
        var(--ink) 0 2px, transparent 2px 4px,
        var(--ink) 4px 5px, transparent 5px 9px,
        var(--ink) 9px 12px, transparent 12px 15px,
        var(--ink) 15px 18px, transparent 18px 21px
    );
    opacity: .8;
    border-radius: 2px;
}
.ticket-hologram {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    flex-shrink: 0;
    background: linear-gradient(120deg, #f7cac9, #cfe8ef, #cdb4db, #f7cac9);
    background-size: 300% 300%;
    animation: holoShift 6s ease infinite;
    display: flex;
    align-items: center;
    justify-content: center;
    color: rgba(26,26,46,.55);
    font-size: .8rem;
    box-shadow: inset 0 0 6px rgba(255,255,255,.7), 0 1px 3px rgba(26,26,46,.25);
}
@keyframes holoShift { 0%, 100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }

.ticket-stub-id {
    margin-top: 8px;
    font-family: 'JetBrains Mono', monospace;
    font-size: .7rem;
    letter-spacing: 2px;
    color: var(--muted);
}

.ticket-caption { color: var(--muted); font-size: .82rem; text-align: center; max-width: 320px; margin: 0 0 4px; }

/* pending state */
.ticket-body-pending p { color: var(--ink); margin: 0 0 10px; font-size: .95rem; }
.ticket-token {
    font-family: 'JetBrains Mono', monospace;
    background: var(--paper-dim);
    border: 1px dashed var(--line);
    border-radius: 8px;
    padding: 8px 12px;
    font-size: .8rem;
    color: var(--ink);
    word-break: break-all;
    margin-bottom: 12px;
}

/* ---------- support card (professional, calm — separate from the ticket) ---------- */
.support-card {
    width: 100%;
    max-width: 380px;
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 16px;
    padding: 22px;
    margin-top: 10px;
    box-shadow: 0 14px 30px -18px rgba(26,26,46,.22);
}
.support-header h3 { margin: 0 0 4px; font-size: 1.05rem; font-weight: 800; color: var(--ink); }
.support-header p { margin: 0 0 16px; font-size: .85rem; color: var(--muted); }

.support-channels { display: flex; flex-direction: column; gap: 10px; margin-bottom: 14px; }
.support-channel {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 14px;
    border-radius: 12px;
    background: var(--paper-dim);
    text-decoration: none;
    transition: background .15s ease, transform .15s ease;
}
.support-channel:hover { background: #EAE2CB; transform: translateX(2px); }
.support-icon {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--brand);
    color: #fff;
    font-size: 1rem;
    flex-shrink: 0;
}
.support-channel.whatsapp .support-icon { background: #25D366; }
.support-text { display: flex; flex-direction: column; flex: 1; }
.support-text strong { font-size: .85rem; color: var(--ink); }
.support-text span { font-family: 'JetBrains Mono', monospace; font-size: .82rem; color: var(--muted); }
.support-arrow { color: var(--muted); font-size: .8rem; transition: transform .15s ease, color .15s ease; }
.support-channel:hover .support-arrow { transform: translateX(3px); color: var(--ink); }

.support-hours {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: .8rem;
    color: var(--muted);
    padding-top: 12px;
    border-top: 1px solid var(--line);
}
.support-hours i { color: var(--brand-dark); }

@media (max-width: 480px) {
    .ticket-stage { padding: 40px 12px; }
    .ticket-3d { max-width: 100%; }
    .ticket-paper { padding: 20px 16px 16px; }
    .ticket-headline h2 { font-size: 1.1rem; }
    .ticket-value { font-size: .82rem; }
    .support-card { padding: 18px; }
}

@media (max-width: 360px) {
    .ticket-paper { padding: 16px 10px 12px; }
    .ticket-value { font-size: .75rem; }
    .ticket-label { font-size: .6rem; }
    #qrcode canvas, #qrcode img { max-width: 100px !important; height: auto !important; }
}

@media (prefers-reduced-motion: reduce) {
    .ticket-3d, .ticket-stamp, .ticket-sheen, .ticket-hologram {
        animation: none !important;
    }
}
</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/pages/merci.blade.php ENDPATH**/ ?>