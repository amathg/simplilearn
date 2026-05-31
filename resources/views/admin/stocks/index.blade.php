@extends('layouts.admin')
@section('title', 'Gestion des stocks')
@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif

<div class="page-header">
  <h1>Stocks</h1>
  <a href="{{ route('admin.stocks.mouvements') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD">
    <i class="ti ti-history"></i> Mouvements
  </a>
</div>

@if($alertes->count() > 0)
<div class="alert-ko" style="margin-bottom:1rem">
  <i class="ti ti-alert-triangle"></i>
  <strong>{{ $alertes->count() }} produit{{ $alertes->count()>1?'s':'' }} en alerte stock !</strong>
</div>
@endif

<!-- Ajuster stock -->
<div class="card" style="padding:1.5rem;margin-bottom:1.5rem">
  <h2 style="font-family:'Syne',sans-serif;font-weight:700;font-size:14px;margin-bottom:1rem">
    <i class="ti ti-adjustments" style="color:var(--primary)"></i> Ajuster le stock
  </h2>
  <form method="POST" action="{{ route('admin.stocks.ajuster') }}" style="display:grid;grid-template-columns:2fr 1fr 1fr 2fr auto;gap:1rem;align-items:end">
    @csrf
    <div class="fg" style="margin:0">
      <label>Produit</label>
      <select name="produit_id" required>
        <option value="">— Choisir —</option>
        @foreach($produits as $p)
        <option value="{{ $p->id }}">{{ $p->nom }} (stock: {{ $p->stock?->quantite ?? 0 }})</option>
        @endforeach
      </select>
    </div>
    <div class="fg" style="margin:0">
      <label>Type</label>
      <select name="type">
        <option value="entree">Entrée</option>
        <option value="sortie">Sortie</option>
      </select>
    </div>
    <div class="fg" style="margin:0">
      <label>Quantité</label>
      <input type="number" name="quantite" min="1" required>
    </div>
    <div class="fg" style="margin:0">
      <label>Motif</label>
      <input type="text" name="motif" placeholder="ex: réception commande">
    </div>
    <button type="submit" class="btn btn-gold"><i class="ti ti-check"></i> Valider</button>
  </form>
</div>

<div class="card">
  <div class="card-head">
    <h2><i class="ti ti-building-warehouse"></i> {{ $produits->count() }} produits</h2>
  </div>
  <table>
    <thead>
      <tr><th>Produit</th><th>Catégorie</th><th>Marque</th><th>Stock actuel</th><th>Stock min</th><th>Statut</th></tr>
    </thead>
    <tbody>
      @foreach($produits as $p)
      <tr>
        <td><strong>{{ $p->nom }}</strong><br><span style="font-size:11px;color:#888">{{ $p->code_barres }}</span></td>
        <td style="font-size:12px;color:#888">{{ $p->categorie?->nom ?? '—' }}</td>
        <td style="font-size:12px;color:#888">{{ $p->marque?->nom ?? '—' }}</td>
        <td><strong style="font-size:16px">{{ $p->stock?->quantite ?? 0 }}</strong></td>
        <td style="color:#888">{{ $p->stock_minimum }}</td>
        <td>
          @php $qte = $p->stock?->quantite ?? 0; @endphp
          @if($qte == 0)
            <span class="badge badge-danger">Rupture</span>
          @elseif($qte <= $p->stock_minimum)
            <span class="badge badge-warning">Alerte</span>
          @else
            <span class="badge badge-success">OK</span>
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection