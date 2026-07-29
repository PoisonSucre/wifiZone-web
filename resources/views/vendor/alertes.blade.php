@extends('layouts.vendor')
@section('sidebar') @include('components.sidebar-vendor') @endsection
@section('title', 'Alertes paiements')
@section('header')
@endsection
@section('content')
    @livewire('vendor.alertes')
@endsection
