@extends('layouts.vendor')
@section('sidebar') @include('components.sidebar-vendor') @endsection
@section('title', 'Mes Tickets')
@php
    $hsId = (int) request()->query('hotspot', 0);
    $activeHotspot = $hsId > 0 ? \App\Models\Hotspot::where('id', $hsId)->where('vendeur_id', auth()->id())->first() : null;
@endphp
@section('header')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-1">
    <div class="flex items-center gap-3">
        <div class="relative w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 via-blue-500/90 to-blue-400 flex items-center justify-center text-white text-lg shadow-[0_10px_30px_-10px_rgba(59,130,246,0.55)]">
            <i class="fas fa-ticket"></i>
            <span class="absolute -top-0.5 -right-0.5 w-3 h-3 rounded-full bg-emerald-400 border-2 border-white dark:border-darkCard"></span>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-[0.2em]">Gestion</p>
            <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight mt-1">Mes Tickets</h2>
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
        <a href="{{ route('vendor.import') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-neonGreen hover:bg-neonGreen-600 text-black text-[11px] font-bold transition-all shadow-sm hover:shadow-md">
            <i class="fas fa-plus text-[10px]"></i> Ajouter
        </a>
    </div>
</div>
@endsection
@section('content')
    @livewire('vendor.ticket-list')
@endsection
