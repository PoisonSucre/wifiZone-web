@extends('layouts.vendor')
@section('sidebar') @include('components.sidebar-vendor') @endsection
@section('title', 'Mon Portail')
@php
    $shopUrl = auth()->user()?->shopUrl() ?? '#';
    $hsId = (int) request()->query('hotspot', 0);
    $activeHotspot = $hsId > 0 ? \App\Models\Hotspot::where('id', $hsId)->where('vendeur_id', auth()->id())->first() : null;
@endphp
@section('header')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-1">
    <div class="flex items-center gap-3">
        <div class="relative w-12 h-12 rounded-2xl bg-gradient-to-br from-neonGreen via-neonGreen/90 to-emerald-400 flex items-center justify-center text-black text-lg shadow-[0_10px_30px_-10px_rgba(0,255,136,0.55)]">
            <i class="fas fa-store"></i>
            <span class="absolute -top-0.5 -right-0.5 w-3 h-3 rounded-full bg-emerald-400 border-2 border-white dark:border-darkCard"></span>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-[0.2em]">Personnalisation</p>
            <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight mt-1">Mon Portail</h2>
        </div>
    </div>
    <div class="flex items-center gap-2">
        @if ($activeHotspot)
            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-neonGreen/10 text-neonGreen dark:text-neonGreen-400 text-xs font-bold border border-neonGreen/20">
                <i class="fas fa-wifi text-[10px]"></i> {{ $activeHotspot->name }}
            </span>
        @else
            <a href="{{ route('vendor.hotspot') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-100 dark:bg-darkBg text-slate-600 dark:text-gray-300 text-[11px] font-bold hover:bg-slate-200 dark:hover:bg-darkBorder transition">
                <i class="fas fa-wifi text-[10px]"></i> Choisir un hotspot
            </a>
        @endif
        <a href="{{ $shopUrl }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-neonGreen hover:bg-neonGreen-600 text-black text-[11px] font-bold transition-all shadow-sm hover:shadow-md">
            <i class="fas fa-external-link-alt text-[10px]"></i> Voir mon portail
        </a>
    </div>
</div>
@endsection
@section('content')
    @livewire('vendor.boutique-manager')
@endsection
