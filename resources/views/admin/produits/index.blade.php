@extends('layouts.admin')

@section('title', 'Produits')

@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif

<div class="page-header">
  <h1>Produits</h1>
  <a href="{{ route('admin.produits.create') }}" class="btn btn-gold">
    <i class="ti ti-plus"></i> Ajouter
  </a>
</div>

<div class="card">
  <div class="card-head">
    <h2><i class="ti ti-package"></i> {{ $produits->count() }} produit{{ $produits->count() > 1 ? 's' : '' }}</h2>
  </div>
  <table>
    <thead>
      <tr><th>Produit</th><th>Catégorie</th><th>Prix</th><th>Stock</th><th>Visible</th><th></th></tr>
    </thead>
    <tbody>
      @forelse($produits as $p)
      <tr>
        <td><strong>{{ $p->nom }}</strong></td>
        <td style="color:#888;font-size:12px">{{ $p->categorie?->nom ?? '—' }}</td>
        <td><strong>{{ number_format($p->prix_vente, 0, ',', ' ') }} {{ session('boutique.devise', 'FCFA') }}</strong></td>
        <td>
          @if($p->stock?->quantite == 0)
            <span class="badge badge-danger">Rupture</span>
          @elseif($p->stock?->quantite <= 3)
            <span class="badge badge-warning">{{ $p->stock->quantite }}</span>
          @else
            <span style="color:#22C55E;font-weight:700">{{ $p->stock?->quantite ?? 0 }}</span>
          @endif
        </td>
        <td>
          <span class="badge {{ $p->visible ? 'badge-success' : 'badge-gray' }}">
            {{ $p->visible ? 'Oui' : 'Non' }}
          </span>
        </td>
        <td style="display:flex;gap:6px">
          <a href="{{ route('admin.produits.edit', $p) }}" class="btn btn-sm btn-gold">
            <i class="ti ti-edit"></i>
          </a>
          <form method="POST" action="{{ route('admin.produits.destroy', $p) }}" onsubmit="return confirm('Supprimer ?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-sm btn-red"><i class="ti ti-trash"></i></button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" style="text-align:center;padding:2rem;color:#aaa">Aucun produit.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

@endsection