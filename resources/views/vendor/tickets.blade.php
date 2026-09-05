@extends('layouts.vendor')
@section('sidebar') @include('components.sidebar-vendor') @endsection
@section('title', 'Mes Tickets')
@php
    $hsId = (int) request()->query('hotspot', 0);
    $activeHotspot = $hsId > 0 ? \App\Models\Hotspot::where('id', $hsId)->where('vendeur_id', auth()->id())->first() : null;
@endphp
@section('header')
<div class="flex items-center justify-between gap-2 pb-1">
    <div class="flex items-center gap-2.5 min-w-0">
        <div class="relative w-9 h-9 sm:w-10 sm:h-10 shrink-0 rounded-xl bg-gradient-to-br from-blue-500 via-blue-500/90 to-blue-400 flex items-center justify-center text-white text-sm sm:text-base shadow-[0_8px_20px_-8px_rgba(59,130,246,0.5)]">
            <i class="fas fa-ticket"></i>
            <span class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-emerald-400 border-2 border-white dark:border-darkCard"></span>
        </div>
        <div class="min-w-0">
            <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-[0.16em]">Gestion</p>
            <h2 class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight truncate">Mes Tickets</h2>
        </div>
    </div>
    <div class="flex items-center gap-1.5 shrink-0">
        @if ($activeHotspot)
            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-neonGreen/10 text-neonGreen dark:text-neonGreen-400 text-[10px] font-bold border border-neonGreen/20">
                <i class="fas fa-wifi text-[9px]"></i> {{ $activeHotspot->name }}
            </span>
        @else
            <a href="{{ route('vendor.hotspot') }}" class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-slate-100 dark:bg-darkBg text-slate-600 dark:text-gray-300 text-[10px] font-bold hover:bg-slate-200 dark:hover:bg-darkBorder transition">
                <i class="fas fa-wifi text-[9px]"></i> <span class="hidden sm:inline">Choisir un hotspot</span><span class="inline sm:hidden">Hotspot</span>
            </a>
        @endif
        <a href="{{ route('vendor.import', $hsId > 0 ? ['hotspot' => $hsId] : []) }}" class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-neonGreen hover:bg-neonGreen-600 text-white text-[10px] font-bold transition-all shadow-sm hover:shadow-md">
            <i class="fas fa-plus text-[9px]"></i> <span class="hidden sm:inline">Ajouter</span>
        </a>
    </div>
</div>
@endsection
@section('content')
    @livewire('vendor.ticket-list')
@endsection
