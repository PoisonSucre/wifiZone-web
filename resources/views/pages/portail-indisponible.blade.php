@extends('layouts.public')

@section('title', 'Portail indisponible - ' . config('platform.name'))

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-md">
        @php
            $raison = $raison ?? '';
            $theme = $raison === 'gele'
                ? ['icon' => 'fa-snowflake', 'iconBg' => 'bg-amber-500/10', 'iconColor' => 'text-amber-500', 'title' => 'Portail gelé', 'titleColor' => 'text-amber-600 dark:text-amber-400', 'msg' => 'Ce portail est actuellement <strong>gelé</strong>.']
                : ($raison === 'desactive'
                    ? ['icon' => 'fa-ban', 'iconBg' => 'bg-red-500/10', 'iconColor' => 'text-red-500', 'title' => 'Portail désactivé', 'titleColor' => 'text-red-600 dark:text-red-400', 'msg' => 'Ce portail a été <strong>désactivé</strong>.']
                    : ['icon' => 'fa-exclamation-triangle', 'iconBg' => 'bg-amber-500/10', 'iconColor' => 'text-amber-500', 'title' => 'Portail indisponible', 'titleColor' => 'text-amber-600 dark:text-amber-400', 'msg' => 'Ce portail est actuellement indisponible.']);
        @endphp

        <div class="bg-white dark:bg-darkCard border border-slate-200/80 dark:border-darkBorder rounded-2xl shadow-sm p-8 text-center">
            <div class="w-16 h-16 mx-auto rounded-2xl {{ $theme['iconBg'] }} flex items-center justify-center mb-5">
                <i class="fas {{ $theme['icon'] }} {{ $theme['iconColor'] }} text-2xl"></i>
            </div>

            <h2 class="text-xl sm:text-2xl font-extrabold {{ $theme['titleColor'] }} mb-2 tracking-tight">
                {{ $theme['title'] }}
            </h2>

            <p class="text-sm text-slate-600 dark:text-gray-400 leading-relaxed">
                {!! $theme['msg'] !!} La vente de tickets est temporairement suspendue.
            </p>

            <p class="text-sm text-slate-600 dark:text-gray-400 leading-relaxed mt-1">
                Veuillez contacter le vendeur pour débloquer l'accès.
            </p>

            @if(($vendeur ?? null) && $vendeur->telephone)
            <a href="tel:{{ $vendeur->telephone }}"
               class="mt-6 inline-flex items-center justify-center gap-2 w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-darkBg/60 border border-slate-200 dark:border-darkBorder text-slate-900 dark:text-white font-bold text-sm hover:border-neonGreen/50 hover:bg-neonGreen/5 transition-all">
                <span class="w-9 h-9 shrink-0 rounded-lg bg-neonGreen/10 flex items-center justify-center text-neonGreen">
                    <i class="fas fa-phone text-sm"></i>
                </span>
                <span class="flex-1 text-left">
                    <span class="block text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest">Contactez le vendeur</span>
                    <span class="block text-sm font-extrabold tabular-nums">{{ $vendeur->telephone }}</span>
                </span>
                <i class="fas fa-chevron-right text-[10px] text-slate-400"></i>
            </a>
            @endif
        </div>
    </div>
</div>
@endsection
