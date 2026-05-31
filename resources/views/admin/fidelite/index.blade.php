@extends('layouts.admin')
@section('title', 'Fidélité clients')
@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif

<div class="page-header">
  <h1>CRM & Fidélité</h1>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;align-items:start">
  <div class="card">
    <div class="card-head">
      <h2><i class="ti ti-heart"></i> {{ $cartes->count() }} carte{{ $cartes->count()>1?'s':'' }} de fidélité</h2>
    </div>
    <table>
      <thead><tr><th>Client</th><th>Numéro</th><th>Points</th><th>Niveau</th><th>Valeur</th></tr></thead>
      <tbody>
        @forelse($cartes as $c)
        <tr>
          <td><strong>{{ $c->client?->prenom }} {{ $c->client?->nom }}</strong><br><span style="font-size:11px;color:#888">{{ $c->client?->email }}</span></td>
          <td style="font-size:12px;color:#888;font-family:monospace">{{ $c->numero }}</td>
          <td><strong>{{ number_format($c->points) }} pts</strong></td>
          <td>
            <span class="badge badge-{{ match($c->niveau) {'platine'=>'dark','or'=>'warning','argent'=>'info',default=>'gray'} }}">
              {{ ucfirst($c->niveau) }}
            </span>
          </td>
          <td>{{ number_format($c->valeur_totale,0,',',' ') }} {{ session('boutique.devise','FCFA') }}</td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;padding:2rem;color:#aaa">Aucune carte.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="card" style="padding:1.25rem">
    <h2 style="font-family:'Syne',sans-serif;font-weight:700;font-size:13px;margin-bottom:1rem">Créer une carte</h2>
    <form method="POST" action="{{ route('admin.fidelite.carte') }}" class="f-grid">
      @csrf
      <div class="fg">
        <label>Client</label>
        <select name="client_id" required>
          <option value="">— Choisir —</option>
          @foreach($clients as $cl)
          <option value="{{ $cl->id }}">{{ $cl->prenom }} {{ $cl->nom }}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="btn btn-gold" style="width:100%;justify-content:center">
        <i class="ti ti-plus"></i> Créer la carte
      </button>
    </form>
  </div>
</div>
@endsection