@extends('layouts.admin')
@section('title', 'Facture '.$achat->reference)
@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif

<div style="margin-bottom:1rem">
  <a href="{{ route('admin.achats.index') }}" style="font-size:13px;color:#888;display:inline-flex;align-items:center;gap:6px">
    <i class="ti ti-arrow-left"></i> Retour
  </a>
</div>

<div style="display:grid;grid-template-columns:1fr 280px;gap:1.5rem;align-items:start">
  <div class="card" style="padding:1.5rem">
    <div style="display:flex;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem">
      <div>
        <h2 style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.1rem">{{ $achat->reference }}</h2>
        <p style="font-size:13px;color:#888;margin-top:4px">Fournisseur : <strong>{{ $achat->fournisseur?->nom }}</strong></p>
        <p style="font-size:13px;color:#888">Date : {{ $achat->date_facture->format('d/m/Y') }}</p>
        @if($achat->notes)<p style="font-size:13px;color:#888;margin-top:.5rem">{{ $achat->notes }}</p>@endif
      </div>
      <span class="badge badge-{{ match($achat->statut) {'payee'=>'success','partielle'=>'warning','annulee'=>'danger',default=>'gray'} }}" style="height:fit-content">
        {{ ucfirst($achat->statut) }}
      </span>
    </div>

    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem">
      <div style="background:#F5F5F0;border-radius:6px;padding:1rem;text-align:center">
        <div style="font-size:11px;color:#888;text-transform:uppercase;margin-bottom:4px">Montant TTC</div>
        <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.25rem">{{ number_format($achat->montant_ttc,0,',',' ') }}</div>
      </div>
      <div style="background:#F0FDF4;border-radius:6px;padding:1rem;text-align:center">
        <div style="font-size:11px;color:#888;text-transform:uppercase;margin-bottom:4px">Payé</div>
        <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.25rem;color:#22C55E">{{ number_format($achat->montant_paye,0,',',' ') }}</div>
      </div>
      <div style="background:#FEF2F2;border-radius:6px;padding:1rem;text-align:center">
        <div style="font-size:11px;color:#888;text-transform:uppercase;margin-bottom:4px">Reste</div>
        <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.25rem;color:#EF4444">{{ number_format($achat->montant_reste,0,',',' ') }}</div>
      </div>
    </div>
  </div>

  @if($achat->statut !== 'payee')
  <div class="card" style="padding:1.25rem">
    <p style="font-size:11px;text-transform:uppercase;color:#888;margin-bottom:1rem">Enregistrer un paiement</p>
    <form method="POST" action="{{ route('admin.achats.recevoir', $achat) }}" class="f-grid">
      @csrf
      <div class="fg"><label>Montant payé</label><input type="number" name="montant_paye" min="0" step="0.01" required placeholder="0" max="{{ $achat->montant_reste }}"></div>
      <button type="submit" class="btn btn-gold" style="width:100%;justify-content:center">
        <i class="ti ti-check"></i> Valider paiement
      </button>
    </form>
  </div>
  @endif
</div>
@endsection