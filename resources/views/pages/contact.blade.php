@extends('layouts.public')

@section('title', 'Contact - ' . config('platform.name'))

@section('navbar')
<header id="main-header" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 py-6 px-4 sm:px-6 lg:px-8">
    <div id="header-container" class="max-w-7xl mx-auto rounded-full bg-transparent border border-transparent px-6 py-2.5 flex items-center justify-between transition-all duration-500">
        <a href="/" class="flex items-center gap-1 sm:gap-3 text-[10px] sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-wide text-glow transition-all duration-300 hover:scale-105 whitespace-nowrap shrink-0">
            <span class="text-neonGreen"><i class="fas fa-wifi animate-pulse"></i></span>
            {{ config('platform.name') }}
        </a>
        <div class="flex items-center gap-2 sm:gap-4">
            <button id="theme-toggle" onclick="toggleTheme()" class="p-2 sm:p-2.5 rounded-full text-slate-600 dark:text-gray-400 hover:bg-slate-100/55 dark:hover:bg-darkBorder/55 transition-all duration-300" aria-label="Changer de thème">
                <i id="theme-toggle-light-icon" class="fas fa-sun text-amber-500 text-base sm:text-lg hidden dark:inline"></i>
                <i id="theme-toggle-dark-icon" class="fas fa-moon text-base sm:text-lg inline dark:hidden"></i>
            </button>
            <a href="{{ route('vendor.login') }}" class="hidden sm:inline-block px-4 py-2 text-sm font-semibold text-slate-700 dark:text-gray-300 hover:text-slate-950 dark:hover:text-white transition-colors duration-300">Connexion</a>
            <a href="{{ route('vendor.register') }}" class="relative overflow-hidden bg-neonGreen hover:bg-neonGreen-400 text-white dark:text-white font-bold text-xs sm:text-sm px-4 sm:px-6 py-2.5 rounded-full hover:shadow-[0_0_25px_rgba(16,185,129,0.4)] shadow-neon-button transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2 group">
                <span>S'inscrire</span>
                <i class="fas fa-arrow-right text-xs transition-transform duration-300 group-hover:translate-x-1"></i>
            </a>
        </div>
    </div>
</header>
@endsection

@section('content')
<section class="relative overflow-hidden bg-slate-50 dark:bg-[#0A0A0C] pt-28 sm:pt-36 lg:pt-40 pb-8 sm:pb-12 transition-colors duration-300">
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-neonGreen/5 filter blur-3xl rounded-full scale-75 -translate-y-12"></div>
    </div>
    <div class="relative z-20 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-neonGreen/10 border border-neonGreen/20 text-neonGreen text-xs font-bold tracking-wider uppercase mb-4">
            <i class="fas fa-headset"></i> Support & Contact
        </div>
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-tight sm:leading-none mb-3">
            Besoin d'aide ?<br><span class="text-neonGreen text-glow">Contactez-nous</span>
        </h1>
        <p class="text-sm sm:text-base text-slate-600 dark:text-gray-400 max-w-xl mx-auto">
            Notre équipe est disponible pour répondre à toutes vos questions et vous fournir un support technique de qualité.
        </p>
    </div>
</section>

<section class="py-16 sm:py-24 bg-white dark:bg-darkBg transition-colors duration-300">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-start">
            <div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-2">Nos coordonnées</h2>
                <p class="text-sm text-slate-500 dark:text-gray-400 mb-10">N'hésitez pas à nous joindre par le moyen qui vous convient.</p>
                <div class="space-y-8">
                    <div class="flex items-start gap-5">
                        <div class="w-12 h-12 rounded-2xl bg-neonGreen/10 flex items-center justify-center text-neonGreen text-lg shrink-0"><i class="fab fa-whatsapp"></i></div>
                        <div>
                            <h3 class="font-bold text-slate-900 dark:text-white mb-1">WhatsApp</h3>
                            <p class="text-sm text-slate-500 dark:text-gray-400">Disponible du lundi au samedi</p>
                            <a href="tel:+22566635958" class="text-neonGreen font-semibold text-sm hover:underline">66-63-59-58</a>
                            <span class="text-slate-400 dark:text-gray-500 text-sm mx-1">/</span>
                            <a href="tel:+22564658644" class="text-neonGreen font-semibold text-sm hover:underline">64-65-86-44</a>
                        </div>
                    </div>
                    <div class="flex items-start gap-5">
                        <div class="w-12 h-12 rounded-2xl bg-neonGreen/10 flex items-center justify-center text-neonGreen text-lg shrink-0"><i class="fas fa-envelope"></i></div>
                        <div>
                            <h3 class="font-bold text-slate-900 dark:text-white mb-1">Email</h3>
                            <p class="text-sm text-slate-500 dark:text-gray-400 mb-1">Envoyez-nous un message à</p>
                            <a href="mailto:admin@wifipourtous.com" class="text-neonGreen font-semibold text-sm hover:underline">admin@wifipourtous.com</a>
                        </div>
                    </div>
                    <div class="flex items-start gap-5">
                        <div class="w-12 h-12 rounded-2xl bg-neonGreen/10 flex items-center justify-center text-neonGreen text-lg shrink-0"><i class="fas fa-map-marker-alt"></i></div>
                        <div>
                            <h3 class="font-bold text-slate-900 dark:text-white mb-1">Adresse</h3>
                            <p class="text-sm text-slate-500 dark:text-gray-400">Retrouvez-nous à</p>
                            <p class="text-neonGreen font-semibold text-sm">Ouagadougou, Burkina Faso</p>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-2">
                    Pourquoi nous <span class="text-neonGreen text-glow">contacter</span> ?
                </h2>
                <p class="text-sm text-slate-500 dark:text-gray-400 mb-10">Nous sommes à votre écoute pour toute demande.</p>
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-lg bg-neonGreen/10 flex items-center justify-center text-neonGreen shrink-0"><i class="fas fa-tools text-xs"></i></div>
                        <div>
                            <h3 class="font-bold text-slate-900 dark:text-white mb-1 text-sm">Support technique</h3>
                            <p class="text-xs text-slate-500 dark:text-gray-400 leading-relaxed">Assistance pour l'installation et la configuration de votre point d'accès WiFi avec notre plateforme.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-lg bg-neonGreen/10 flex items-center justify-center text-neonGreen shrink-0"><i class="fas fa-handshake text-xs"></i></div>
                        <div>
                            <h3 class="font-bold text-slate-900 dark:text-white mb-1 text-sm">Partenariat</h3>
                            <p class="text-xs text-slate-500 dark:text-gray-400 leading-relaxed">Vous souhaitez collaborer avec nous ? Discutons de votre projet.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-lg bg-neonGreen/10 flex items-center justify-center text-neonGreen shrink-0"><i class="fas fa-bug text-xs"></i></div>
                        <div>
                            <h3 class="font-bold text-slate-900 dark:text-white mb-1 text-sm">Signaler un problème</h3>
                            <p class="text-xs text-slate-500 dark:text-gray-400 leading-relaxed">Un bug ou une anomalie ? Informez-nous pour que nous puissions résoudre rapidement.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-lg bg-neonGreen/10 flex items-center justify-center text-neonGreen shrink-0"><i class="fas fa-lightbulb text-xs"></i></div>
                        <div>
                            <h3 class="font-bold text-slate-900 dark:text-white mb-1 text-sm">Suggestions & améliorations</h3>
                            <p class="text-xs text-slate-500 dark:text-gray-400 leading-relaxed">Vos idées comptent. Partagez vos suggestions pour améliorer la plateforme.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-16 sm:py-24 relative overflow-hidden bg-white dark:bg-darkBg transition-colors duration-300">
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-neonGreen/5 filter blur-3xl rounded-full scale-75 -translate-y-12"></div>
    </div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10 space-y-6 sm:space-y-8">
        <h2 class="text-2xl sm:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">
            Prêt à rentabiliser votre <span class="text-neonGreen text-glow">WiFi Zone</span> ?
        </h2>
        <p class="text-base sm:text-lg text-slate-600 dark:text-gray-400 max-w-2xl mx-auto">
            Rejoignez les dizaines de propriétaires de réseaux Wi-Fi qui automatisent déjà leurs ventes en ligne.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('vendor.register') }}" class="w-full sm:w-auto text-center bg-neonGreen text-white dark:text-white font-extrabold px-10 py-4 rounded-full shadow-neon-button hover:bg-neonGreen-400 transition-all transform hover:-translate-y-1">
                Devenir Vendeur Maintenant
            </a>
            <a href="/" class="w-full sm:w-auto text-center bg-slate-100 dark:bg-transparent hover:bg-slate-200 dark:hover:bg-darkCard border border-slate-200 dark:border-darkBorder text-slate-700 dark:text-gray-300 hover:text-slate-900 dark:hover:text-white font-bold px-10 py-4 rounded-full transition-all shadow-sm">
                Retour à l'accueil
            </a>
        </div>
    </div>
</section>

@push('scripts')
<script>
    const mainHeader = document.getElementById('main-header');
    const headerContainer = document.getElementById('header-container');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 20) {
            mainHeader.classList.remove('py-6');
            mainHeader.classList.add('py-3');
            headerContainer.classList.add('header-scrolled');
        } else {
            mainHeader.classList.remove('py-3');
            mainHeader.classList.add('py-6');
            headerContainer.classList.remove('header-scrolled');
        }
    });
    if (window.scrollY > 20) {
        mainHeader.classList.remove('py-6');
        mainHeader.classList.add('py-3');
        headerContainer.classList.add('header-scrolled');
    }


</script>
@endpush
@endsection
