@extends('layouts.vendor')
@section('sidebar') @include('components.sidebar-vendor') @endsection
@section('title', 'Mes Hotspots')
@section('header')
<div class="flex items-center justify-between gap-2 pb-1">
    <div class="flex items-center gap-2.5 min-w-0">
        <div class="relative w-9 h-9 sm:w-10 sm:h-10 shrink-0 rounded-xl bg-gradient-to-br from-cyan-400 via-blue-500 to-indigo-500 flex items-center justify-center text-white text-sm sm:text-base shadow-[0_8px_20px_-8px_rgba(6,182,212,0.5)]">
            <i class="fas fa-wifi"></i>
            <span class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-emerald-400 border-2 border-white dark:border-darkCard"></span>
        </div>
        <div class="min-w-0">
            <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-[0.16em]">Gestion</p>
            <h2 class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight truncate">Mes Hotspots</h2>
        </div>
    </div>
    @include('components.hotspot-create-button')
</div>
@endsection
@section('content')
    @livewire('vendor.hotspot-manager')
@endsection
