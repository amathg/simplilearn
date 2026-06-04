@extends('layouts.admin')
@section('title', 'Inventaires')
@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif

<div class="page-header">
  <h1>Inventaires & Stock</h1>
  <a href="{{ route('admin.inventaires.pdf') }}" class="btn btn-gold"><i class="ti ti-file-type-pdf"></i> Exporter en PDF</a>
</div>

<div style="display:grid;grid-template-columns:repeat(6,1fr);gap:1rem;margin-bottom:1.5rem">
  <div class="card" style="padding:1rem;text-align:center">
    <div style="font-size:11px;text-transform:uppercase;letter-spacing:.5px;color:#888;margin-bottom:.4rem">Produits</div>
    <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.5rem">{{ $totalProduits }}</div>
    <div style="font-size:11px;color:#aaa">références</div>
  </div>
  <div class="card" style="padding:1rem;text-align:center">
    <div style="font-size:11px;text-transform:uppercase;letter-spacing:.5px;color:#888;margin-bottom:.4rem">Qté en stock</div>
    <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.5rem">{{ number_format($totalQuantite, 0, ',', ' ') }}</div>
    <div style="font-size:11px;color:#aaa">unités</div>
  </div>
  <div class="card" style="padding:1rem;text-align:center">
    <div style="font-size:11px;text-transform:uppercase;letter-spacing:.5px;color:#888;margin-bottom:.4rem">Valeur stock</div>
    <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.2rem;color:var(--primary)">{{ number_format($valeurStock, 0, ',', ' ') }}</div>
    <div style="font-size:11px;color:#aaa">au prix d'achat</div>
  </div>
  <div class="card" style="padding:1rem;text-align:center">
    <div style="font-size:11px;text-transform:uppercase;letter-spacing:.5px;color:#888;margin-bottom:.4rem">Valeur vente</div>
    <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.2rem;color:#22C55E">{{ number_format($valeurVente, 0, ',', ' ') }}</div>
    <div style="font-size:11px;color:#aaa">au prix de vente</div>
  </div>
  <div class="card" style="padding:1rem;text-align:center;border:.5px solid {{ $produitsAlertes > 0 ? '#F59E0B' : '#E5E5E0' }}">
    <div style="font-size:11px;text-transform:uppercase;letter-spacing:.5px;color:#888;margin-bottom:.4rem">Alertes stock</div>
    <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.5rem;color:{{ $produitsAlertes > 0 ? '#F59E0B' : '#1A1A1A' }}">{{ $produitsAlertes }}</div>
    <div style="font-size:11px;color:#aaa">produits</div>
  </div>
  <div class="card" style="padding:1rem;text-align:center;border:.5px solid {{ $produitsRupture > 0 ? '#EF4444' : '#E5E5E0' }}">
    <div style="font-size:11px;text-transform:uppercase;letter-spacing:.5px;color:#888;margin-bottom:.4rem">Rupture stock</div>
    <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.5rem;color:{{ $produitsRupture > 0 ? '#EF4444' : '#1A1A1A' }}">{{ $produitsRupture }}</div>
    <div style="font-size:11px;color:#aaa">produits</div>
  </div>
</div>

<div class="card" style="margin-bottom:1.5rem">
  <div style="display:flex;align-items:center;justify-content:space-between;padding:1rem 1.25rem;border-bottom:.5px solid #F0F0EB">
    <h2 style="font-family:'Syne',sans-serif;font-weight:700;font-size:14px">
      <i class="ti ti-package" style="color:var(--primary)"></i> État du stock par produit
    </h2>
    <div style="font-size:11px;color:#888">Trié par chiffre d'affaires</div>
  </div>
  <div style="overflow-x:auto">
    <table>
      <thead>
        <tr>
          <th>Produit</th>
          <th style="text-align:right">Stock actuel</th>
          <th style="text-align:right">Alerte</th>
          <th style="text-align:right">Prix achat</th>
          <th style="text-align:right">Prix vente</th>
          <th style="text-align:right">Valeur stock</th>
          <th style="text-align:right">Qté vendue</th>
          <th style="text-align:right">CA généré</th>
          <th style="text-align:center">État</th>
        </tr>
      </thead>
      <tbody>
        @forelse($statsParProduit as $p)
        @php
          $etat = 'ok';
          if ($p['stock'] == 0) $etat = 'rupture';
          elseif ($p['stock'] <= $p['stock_alerte']) $etat = 'alerte';
        @endphp
        <tr style="{{ $etat === 'rupture' ? 'background:#FEF2F2' : ($etat === 'alerte' ? 'background:#FFFBEB' : '') }}">
          <td style="font-weight:600">{{ $p['nom'] }}</td>
          <td style="text-align:right;font-weight:700;font-size:15px;color:{{ $etat === 'rupture' ? '#EF4444' : ($etat === 'alerte' ? '#F59E0B' : '#1A1A1A') }}">
            {{ number_format($p['stock'], 0, ',', ' ') }}
          </td>
          <td style="text-align:right;color:#888;font-size:12px">{{ $p['stock_alerte'] }}</td>
          <td style="text-align:right;font-size:12px">{{ number_format($p['prix_achat'], 0, ',', ' ') }}</td>
          <td style="text-align:right;font-size:12px">{{ number_format($p['prix_vente'], 0, ',', ' ') }}</td>
          <td style="text-align:right;font-weight:600;color:var(--primary)">{{ number_format($p['valeur_stock'], 0, ',', ' ') }}</td>
          <td style="text-align:right;font-size:13px">{{ number_format($p['qte_vendue'], 0, ',', ' ') }}</td>
          <td style="text-align:right;font-weight:700;color:#22C55E">{{ number_format($p['chiffre_affaire'], 0, ',', ' ') }}</td>
          <td style="text-align:center">
            @if($etat === 'rupture')
            <span class="badge badge-danger">Rupture</span>
            @elseif($etat === 'alerte')
            <span class="badge badge-warning">Alerte</span>
            @else
            <span class="badge badge-success">OK</span>
            @endif
          </td>
        </tr>
        @empty
        <tr><td colspan="9" style="text-align:center;padding:2rem;color:#aaa">Aucun produit.</td></tr>
        @endforelse
      </tbody>
      <tfoot style="background:#F9F9F6;font-weight:700">
        <tr>
          <td>TOTAL</td>
          <td style="text-align:right">{{ number_format($totalQuantite, 0, ',', ' ') }}</td>
          <td></td><td></td><td></td>
          <td style="text-align:right;color:var(--primary)">{{ number_format($valeurStock, 0, ',', ' ') }}</td>
          <td style="text-align:right">{{ number_format($statsParProduit->sum('qte_vendue'), 0, ',', ' ') }}</td>
          <td style="text-align:right;color:#22C55E">{{ number_format($statsParProduit->sum('chiffre_affaire'), 0, ',', ' ') }}</td>
          <td></td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<div class="card">
  <div style="padding:1rem 1.25rem;border-bottom:.5px solid #F0F0EB">
    <h2 style="font-family:'Syne',sans-serif;font-weight:700;font-size:14px">
      <i class="ti ti-history" style="color:var(--primary)"></i> Historique des inventaires
    </h2>
  </div>
  <table>
    <thead>
      <tr><th>Référence</th><th>Date</th><th>Statut</th><th>Produits</th><th>Écarts</th><th></th></tr>
    </thead>
    <tbody>
      @forelse($inventaires as $inv)
      @php $ecarts = $inv->lignes->where('ecart', '!=', 0)->count(); @endphp
      <tr>
        <td><strong>{{ $inv->reference }}</strong></td>
        <td>{{ $inv->date_inventaire->format('d/m/Y') }}</td>
        <td>
          <span class="badge badge-{{ match($inv->statut) {
            'valide'   => 'success',
            'en_cours' => 'warning',
            'annule'   => 'danger',
            default    => 'gray'
          } }}">{{ ucfirst(str_replace('_',' ',$inv->statut)) }}</span>
        </td>
        <td>{{ $inv->lignes->count() }} produits</td>
        <td>
          @if($ecarts > 0)
          <span style="color:#EF4444;font-weight:600">{{ $ecarts }} écart(s)</span>
          @else
          <span style="color:#22C55E">Aucun écart</span>
          @endif
        </td>
        <td style="display:flex;gap:6px">
          <a href="{{ route('admin.inventaires.show', $inv) }}" class="btn btn-sm btn-gold"><i class="ti ti-eye"></i></a>
          @if($inv->statut !== 'valide')
          <form method="POST" action="{{ route('admin.inventaires.destroy', $inv) }}" onsubmit="return confirm('Supprimer ?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-sm btn-red"><i class="ti ti-trash"></i></button>
          </form>
          @endif
        </td>
      </tr>
      @empty
      <tr><td colspan="6" style="text-align:center;padding:2rem;color:#aaa">Aucun inventaire.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

@endsection
