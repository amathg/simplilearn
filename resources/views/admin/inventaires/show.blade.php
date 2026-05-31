@extends('layouts.admin')
@section('title', 'Inventaire '.$inventaire->reference)
@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif

<div class="page-header">
  <h1>{{ $inventaire->reference }}</h1>
  <div style="display:flex;gap:.75rem">
    @if($inventaire->statut === 'en_cours')
    <form method="POST" action="{{ route('admin.inventaires.valider', $inventaire) }}">
      @csrf
      <button type="submit" class="btn btn-gold" onclick="return confirm('Valider et mettre à jour les stocks ?')">
        <i class="ti ti-check"></i> Valider & Appliquer
      </button>
    </form>
    @endif
    <a href="{{ route('admin.inventaires.index') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD">
      <i class="ti ti-arrow-left"></i> Retour
    </a>
  </div>
</div>

<div class="card">
  <div class="card-head">
    <h2><i class="ti ti-clipboard-list"></i> {{ $inventaire->lignes->count() }} produits</h2>
    <span class="badge badge-{{ match($inventaire->statut) {'valide'=>'success','en_cours'=>'warning',default=>'gray'} }}">
      {{ ucfirst($inventaire->statut) }}
    </span>
  </div>
  <table>
    <thead>
      <tr><th>Produit</th><th>Stock théorique</th><th>Stock réel</th><th>Écart</th></tr>
    </thead>
    <tbody>
      @foreach($inventaire->lignes as $l)
      <tr>
        <td><strong>{{ $l->produit?->nom }}</strong></td>
        <td>{{ $l->stock_theorique }}</td>
        <td><strong>{{ $l->stock_reel }}</strong></td>
        <td style="color:{{ $l->ecart > 0 ? '#22C55E' : ($l->ecart < 0 ? '#EF4444' : '#888') }};font-weight:700">
          {{ $l->ecart > 0 ? '+'.$l->ecart : $l->ecart }}
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection