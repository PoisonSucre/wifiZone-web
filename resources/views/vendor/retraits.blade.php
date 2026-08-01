@extends('layouts.vendor')
@section('sidebar') @include('components.sidebar-vendor') @endsection
@section('title', 'Retraits')
@section('header')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-1">
    <div class="flex items-center gap-3">
        <div class="relative w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-gradient-to-br from-amber-500 via-amber-500/90 to-orange-400 flex items-center justify-center text-white text-base sm:text-lg shadow-[0_10px_30px_-10px_rgba(245,158,11,0.55)]">
            <i class="fas fa-wallet"></i>
            <span class="absolute -top-0.5 -right-0.5 w-3 h-3 rounded-full bg-emerald-400 border-2 border-white dark:border-darkCard"></span>
        </div>
        <div>
            <p class="text-[10px] sm:text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-[0.2em]">Finance</p>
            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight mt-0.5 sm:mt-1">Mes Retraits</h2>
        </div>
    </div>
</div>
@endsection
@section('content')
    @livewire('vendor.retrait-manager')
@endsection
