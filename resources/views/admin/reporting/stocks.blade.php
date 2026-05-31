@extends('layouts.admin')
@section('title', 'Rapport stocks')
@section('content')

<div class="page-header">
  <h1>Rapport stocks</h1>
  <a href="{{ route('admin.reporting.index') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD">
    <i class="ti ti-arrow-left"></i> Retour
  </a>
</div>

<div class="card">
  <table>
    <thead>
      <tr><th>Produit</th><th>Catégorie</th><th>Stock actuel</th><th>Stock min</th><th>Valeur stock</th><th>Statut</th></tr>
    </thead>
    <tbody>
      @foreach($produits as $p)
      @php $qte = $p->stock?->quantite ?? 0; @endphp
      <tr>
        <td><strong>{{ $p->nom }}</strong></td>
        <td style="color:#888;font-size:12px">{{ $p->categorie?->nom ?? '—' }}</td>
        <td><strong>{{ $qte }}</strong></td>
        <td style="color:#888">{{ $p->stock_minimum }}</td>
        <td>{{ number_format($qte * $p->prix_vente,0,',',' ') }} {{ session('boutique.devise','FCFA') }}</td>
        <td>
          @if($qte == 0)<span class="badge badge-danger">Rupture</span>
          @elseif($qte <= $p->stock_minimum)<span class="badge badge-warning">Alerte</span>
          @else<span class="badge badge-success">OK</span>
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection