@extends('layouts.public')

@section('title', 'Annulation - ' . config('platform.name'))

@section('content')
<div style="display:flex;align-items:center;justify-content:center;min-height:80vh;padding:20px;">
    <div class="card" style="max-width:400px;width:100%;text-align:center;">
        <i class="fas fa-times-circle" style="font-size:3em;color:#e74c3c;margin-bottom:15px;"></i>
        <h2 style="color:#e74c3c;margin-bottom:10px;">Paiement Annulé</h2>
        <p style="color:#666;line-height:1.6;">Votre paiement a été annulé. Aucun montant n'a été débité.</p>
        <p style="margin-top:10px;color:#666;">Vous pouvez réessayer à tout moment.</p>
        @if(!empty($vendeur_id))
        <a href="{{ url('/shop?vendeur_id=' . $vendeur_id) }}" class="btn btn-success" style="width:100%;display:block;margin-top:20px;text-decoration:none;text-align:center;">
            <i class="fas fa-redo"></i> Réessayer
        </a>
        @endif
    </div>
</div>
@endsection
