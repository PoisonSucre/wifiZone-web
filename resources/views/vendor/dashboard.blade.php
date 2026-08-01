@extends('layouts.vendor')
@section('sidebar') @include('components.sidebar-vendor') @endsection
@section('title', 'Dashboard')
@section('header')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-1">
    <div class="flex items-center gap-3">
        <div class="relative w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-gradient-to-br from-neonGreen via-neonGreen/90 to-emerald-400 flex items-center justify-center text-black text-base sm:text-lg shadow-[0_10px_30px_-10px_rgba(0,255,136,0.55)]">
            <i class="fas fa-tachometer-alt"></i>
            <span class="absolute -top-0.5 -right-0.5 w-3 h-3 rounded-full bg-emerald-400 border-2 border-white dark:border-darkCard"></span>
        </div>
        <div>
            <p class="text-[10px] sm:text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-[0.2em]">Vue d'ensemble</p>
            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight mt-0.5 sm:mt-1">Tableau de Bord</h2>
        </div>
    </div>
    <div class="flex flex-wrap items-center gap-2 mt-1 sm:mt-0">
        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200/60 dark:border-emerald-500/20 text-[10px] sm:text-[11px] font-bold text-emerald-700 dark:text-emerald-400">
            <span class="relative flex h-1.5 w-1.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-emerald-500"></span>
            </span>
            En direct
        </div>
        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-100 dark:bg-darkBg border border-slate-200/80 dark:border-darkBorder text-[10px] sm:text-[11px] font-bold text-slate-600 dark:text-gray-400">
            <i class="fas fa-calendar-alt text-[10px]"></i>
            {{ now()->format('d M Y') }}
        </div>
    </div>
</div>
@endsection
@section('content')
    @livewire('vendor.dashboard')
@endsection
