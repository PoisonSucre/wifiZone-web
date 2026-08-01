@extends('layouts.vendor')
@section('sidebar') @include('components.sidebar-vendor') @endsection
@section('title', 'Dashboard')
@section('header')
<div class="flex items-center justify-between gap-2 pb-1">
    <div class="flex items-center gap-2.5 min-w-0">
        <div class="relative w-9 h-9 sm:w-10 sm:h-10 shrink-0 rounded-xl bg-gradient-to-br from-neonGreen via-neonGreen/90 to-emerald-400 flex items-center justify-center text-black text-sm sm:text-base shadow-[0_8px_20px_-8px_rgba(0,255,136,0.5)]">
            <i class="fas fa-tachometer-alt"></i>
            <span class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-emerald-400 border-2 border-white dark:border-darkCard"></span>
        </div>
        <div class="min-w-0">
            <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-[0.16em]">Vue d'ensemble</p>
            <h2 class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight truncate">Tableau de Bord</h2>
        </div>
    </div>
    <div class="flex items-center gap-2 shrink-0">
        <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200/60 dark:border-emerald-500/20 text-[10px] font-bold text-emerald-700 dark:text-emerald-400">
            <span class="relative flex h-1.5 w-1.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-emerald-500"></span>
            </span>
            En direct
        </div>
        <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-[10px] font-bold text-slate-600 dark:text-gray-400">
            <i class="fas fa-calendar-alt text-[9px]"></i>
            {{ now()->format('d M Y') }}
        </div>
    </div>
</div>
@endsection
@section('content')
    @livewire('vendor.dashboard')
@endsection
