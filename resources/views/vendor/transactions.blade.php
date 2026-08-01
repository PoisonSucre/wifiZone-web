@extends('layouts.vendor')
@section('sidebar') @include('components.sidebar-vendor') @endsection
@section('title', 'Transactions')
@section('header')
<div class="flex items-center gap-2.5 pb-1">
    <div class="relative w-9 h-9 sm:w-10 sm:h-10 shrink-0 rounded-xl bg-gradient-to-br from-emerald-500 via-emerald-500/90 to-teal-500 flex items-center justify-center text-white text-sm sm:text-base shadow-[0_8px_20px_-8px_rgba(16,185,129,0.5)]">
        <i class="fas fa-receipt"></i>
    </div>
    <div class="min-w-0">
        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-[0.16em]">Finance</p>
        <h2 class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight truncate">Transactions Quotas</h2>
    </div>
</div>
@endsection
@section('content')
    @livewire('vendor.transaction-list')
@endsection