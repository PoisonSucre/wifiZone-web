@extends('layouts.vendor')
@section('sidebar') @include('components.sidebar-vendor') @endsection
@section('title', 'Mon Profil')
@section('header')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-1">
    <div class="flex items-center gap-3">
        <div class="relative w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500 via-purple-500/90 to-pink-400 flex items-center justify-center text-white text-lg shadow-[0_10px_30px_-10px_rgba(168,85,247,0.55)]">
            <i class="fas fa-user"></i>
            <span class="absolute -top-0.5 -right-0.5 w-3 h-3 rounded-full bg-emerald-400 border-2 border-white dark:border-darkCard"></span>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 dark:text-gray-500 uppercase tracking-[0.2em]">Compte</p>
            <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight mt-1">Mon Profil</h2>
        </div>
    </div>
</div>
@endsection
@section('content')
    @livewire('vendor.profil-editor')
@endsection
