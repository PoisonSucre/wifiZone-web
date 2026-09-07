<?php $__env->startSection('title', 'Récupérer un Ticket - ' . config('platform.name')); ?>

<?php $__env->startSection('navbar'); ?>
    <?php if (isset($component)) { $__componentOriginal1668b5f9e130953f2bdbf60b1b291cc8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1668b5f9e130953f2bdbf60b1b291cc8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar-public','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navbar-public'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1668b5f9e130953f2bdbf60b1b291cc8)): ?>
<?php $attributes = $__attributesOriginal1668b5f9e130953f2bdbf60b1b291cc8; ?>
<?php unset($__attributesOriginal1668b5f9e130953f2bdbf60b1b291cc8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1668b5f9e130953f2bdbf60b1b291cc8)): ?>
<?php $component = $__componentOriginal1668b5f9e130953f2bdbf60b1b291cc8; ?>
<?php unset($__componentOriginal1668b5f9e130953f2bdbf60b1b291cc8); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="ticket-page">
    <div class="ticket-stage">
        
        <div class="w-full max-w-md mb-8">
            <div class="text-center">
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white mb-2">
                    <i class="fas fa-ticket-alt text-neonGreen mr-2"></i> Récupérer un Ticket
                </h2>
                <p class="text-sm text-slate-600 dark:text-gray-400">
                    Entrez le numéro qui a servi au paiement pour retrouver vos identifiants WiFi
                </p>
            </div>

            <form method="POST" action="<?php echo e(route('recuperer-ticket')); ?>" class="space-y-4 mt-6">
                <?php echo csrf_field(); ?>
                <div>
                    <div class="relative">
                        <input type="tel" name="phone" id="phone" required
                                placeholder="Saisissez votre numéro"
                                value="<?php echo e($phone ?? ''); ?>"
                                class="w-full px-4 py-3 rounded-xl bg-white border border-slate-200 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-neonGreen/30 focus:border-neonGreen/50 transition-all">
                        <i class="fas fa-phone absolute right-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    </div>
                </div>
                <button type="submit" id="recupererBtn"
                        class="w-full inline-flex items-center justify-center gap-2 bg-neonGreen text-white font-bold px-4 py-3 text-sm rounded-full shadow-neon-button hover:bg-neonGreen-400 transition-all transform hover:-translate-y-1">
                    <i class="fas fa-search"></i>
                    <span id="btnText">Récupérer mon ticket</span>
                    <i id="btnSpinner" class="fas fa-spinner fa-spin" style="display:none"></i>
                </button>
            </form>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($message ?? '') === 'success' && ($ticket ?? null)): ?>
            <div class="ticket-3d" id="ticketCard">
                <div class="ticket-shadow-layer layer-2"></div>
                <div class="ticket-shadow-layer layer-1"></div>

                <div class="ticket-paper">
                    <div class="ticket-grain" aria-hidden="true"></div>
                    <div class="ticket-sheen" aria-hidden="true"></div>
                    <div class="ticket-stamp">Retrouvé</div>
                    <div class="ticket-crease" aria-hidden="true"></div>

                    <div class="ticket-content">
                            <div class="ticket-top">
                                <div class="ticket-brand">
                                    <span class="ticket-brand-icon"><i class="fas fa-wifi"></i></span>
                                    <span class="ticket-brand-name"><?php echo e(config('platform.name')); ?></span>
                                </div>
                            </div>

                        <div class="ticket-headline">
                            <h2>Votre Ticket</h2>
                        </div>

                        <div class="ticket-perforation" aria-hidden="true"></div>

                        <div class="ticket-body">
                            <div class="ticket-row">
                                <span class="ticket-label">Utilisateur</span>
                                <span class="ticket-value"><?php echo e($ticket->user); ?></span>
                            </div>
                            <div class="ticket-row">
                                <span class="ticket-label">Mot de passe</span>
                                <span class="ticket-value ticket-pw">
                                    <span class="pw-text" data-ticket-id="<?php echo e($ticket->id); ?>" id="tkPass">••••••</span>
                                    <button type="button" class="pw-toggle" aria-label="Afficher le mot de passe">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </span>
                            </div>
                            <div class="ticket-row">
                                <span class="ticket-label">Forfait</span>
                                <span class="ticket-value"><?php echo e($ticket->forfait); ?></span>
                            </div>
                        </div>
                        
                        <div class="ticket-perforation" aria-hidden="true"></div>
                        <div class="ticket-stub-id">Ticket N° <?php echo e($ticket->id); ?></div>
                    </div>
                </div>
            </div>
            <div class="ticket-ground-shadow" id="groundShadow"></div>

        <?php elseif(($message ?? '') === 'not_found'): ?>
            <div class="bg-red-50 border border-red-200 rounded-2xl p-5 text-center animate-fade-in">
                <i class="fas fa-exclamation-circle text-red-500 text-xl mb-2"></i>
                <p class="text-red-700 font-semibold">Aucun ticket trouvé pour ce numéro.</p>
            </div>
        <?php elseif(($message ?? '') === 'missing_input'): ?>
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 text-center animate-fade-in">
                <i class="fas fa-exclamation-triangle text-amber-500 text-xl mb-2"></i>
                <p class="text-amber-700 font-semibold">Veuillez entrer un numéro de téléphone.</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>

<style>
/* --- Styles copiés/adaptés de merci.blade.php --- */
@import url('https://fonts.googleapis.com/css2?family=Manrope:wght@500;700;800&family=JetBrains+Mono:wght@400;600;700&display=swap');

.ticket-page { --paper: #FBF7EC; --paper-dim: #F2EAD6; --ink: #1A1A2E; --muted: #8C8570; --line: #E3D9BE; --brand: #1CA04E; --brand-dark: #14813D; --shadow: 26, 26, 46; font-family: 'Manrope', sans-serif; }
.ticket-stage {
    width: 100%;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 16px;
    padding: 100px 20px 56px; /* Added padding-top to compensate for fixed navbar */
    background: #FFFFFF;
}
.ticket-3d { position: relative; width: 100%; max-width: 380px; margin: 0 auto; transform-style: preserve-3d; }
.ticket-shadow-layer { position: absolute; inset: 0; background: var(--paper-dim); border-radius: 18px; transform-style: preserve-3d; }
.layer-1 { transform: translateZ(-14px) translate(6px, 10px) rotate(2deg); opacity: .85; }
.layer-2 { transform: translateZ(-28px) translate(12px, 20px) rotate(4deg); opacity: .55; }
.ticket-ground-shadow { width: 70%; max-width: 250px; height: 22px; margin: -6px auto 0; background: radial-gradient(ellipse at center, rgba(26,26,46,.32), transparent 72%); filter: blur(5px); }
.ticket-paper { position: relative; background: var(--paper); border-radius: 18px; padding: 28px 28px 20px; box-shadow: 0 12px 22px -10px rgba(var(--shadow), .28); overflow: hidden; }
.ticket-grain { position: absolute; inset: 0; z-index: 0; border-radius: 18px; background-image: radial-gradient(rgba(26,26,46,.05) 1px, transparent 1px); background-size: 3px 3px; pointer-events: none; }
.ticket-content { position: relative; z-index: 1; }
.ticket-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; }
.ticket-brand { display: flex; align-items: center; gap: 8px; font-weight: 800; color: var(--ink); }
.ticket-brand-icon { color: var(--brand); }
.ticket-status { font-size: .68rem; font-weight: 700; text-transform: uppercase; color: var(--brand-dark); background: rgba(28,160,78,.12); padding: 4px 10px; border-radius: 20px; }
.ticket-headline h2 { margin: 0 0 14px; font-size: 1.25rem; color: var(--ink); font-weight: 800; }
.ticket-perforation { position: relative; height: 2px; margin: 18px -28px; background-image: repeating-linear-gradient(to right, var(--line) 0 8px, transparent 8px 18px); }
.ticket-perforation::before, .ticket-perforation::after { content: ""; position: absolute; top: 50%; transform: translateY(-50%); width: 26px; height: 26px; border-radius: 50%; background: #F3F0E6; box-shadow: inset 0 1px 2px rgba(26,26,46,.25); }
.ticket-perforation::before { left: -13px; } .ticket-perforation::after { right: -13px; }
.ticket-body { margin: 2px 0 18px; }
.ticket-row { display: flex; justify-content: space-between; align-items: center; padding: 9px 0; border-bottom: 1px dashed var(--line); }
.ticket-label { font-size: .7rem; text-transform: uppercase; letter-spacing: 1.2px; color: var(--muted); font-weight: 700; }
.ticket-value { font-family: 'JetBrains Mono', monospace; font-weight: 700; color: var(--ink); font-size: .92rem; }
.pw-toggle { background: none; border: none; cursor: pointer; color: var(--brand-dark); font-size: 1rem; }
.ticket-stub-id { margin-top: 12px; font-family: 'JetBrains Mono', monospace; font-size: .7rem; text-align: center; color: var(--muted); }
.ticket-stamp { position: absolute;     top: 24px;
    right: 16px;
    z-index: 2; color: var(--brand-dark); border: 3px solid var(--brand-dark); border-radius: 8px; padding: 3px 11px; font-family: 'JetBrains Mono', monospace; font-weight: 700; font-size: .72rem; transform: rotate(-13deg); opacity: .85; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="<?php echo e(route("recuperer-ticket")); ?>"]');
    if (form) {
        form.addEventListener('submit', function() {
            const btn = document.getElementById('recupererBtn');
            const text = document.getElementById('btnText');
            const spinner = document.getElementById('btnSpinner');
            if (btn && text && spinner) {
                btn.disabled = true;
                text.textContent = 'Recherche...';
                spinner.style.display = 'inline-block';
            }
        });
    }

    // Password toggle - fixed selector to match new structure
    document.querySelectorAll('.pw-toggle').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const wrapper = this.closest('.ticket-pw');
            const span = wrapper.querySelector('.pw-text');
            const icon = this.querySelector('i');
            const ticketId = span.dataset.ticketId;
            
            if (span.textContent === '••••••') {
                span.textContent = '...';
                fetch('/recuperer-ticket/password/' + ticketId)
                    .then(function(r) { return r.json(); })
                    .then(function(d) {
                        span.textContent = d.password;
                        icon.classList.replace('fa-eye', 'fa-eye-slash');
                    })
                    .catch(function(e) {
                        console.error(e);
                        span.textContent = '••••••';
                        alert('Erreur lors de la récupération.');
                    });
            } else {
                span.textContent = '••••••';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/mr_raider/Desktop/tickets/hotspot_sass_laravel/resources/views/pages/recuperer-ticket.blade.php ENDPATH**/ ?>