@extends('layouts.admin')

@section('title', 'Commande '.$vente->reference)

@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif

<div style="margin-bottom:1rem">
  <a href="{{ route('admin.ventes.index') }}" style="font-size:13px;color:#888;display:inline-flex;align-items:center;gap:6px">
    <i class="ti ti-arrow-left"></i> Retour
  </a>
</div>

<div style="display:grid;grid-template-columns:1fr 280px;gap:1.5rem;align-items:start">
  <div class="card" style="padding:1.5rem">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem">
      <div>
        <h2 style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.1rem;margin-bottom:4px">
          {{ $vente->reference }}
        </h2>
        <span class="badge badge-{{ match($vente->statut) {
          'en_attente' => 'warning',
          'confirmee'  => 'success',
          'prete'      => 'info',
          'livree'     => 'gray',
          'annulee'    => 'danger',
          default      => 'gray'
        } }}">{{ $vente->statut }}</span>
      </div>
      <div style="text-align:right;font-size:13px;color:#888">
        <div>Client : <strong>{{ $vente->client?->prenom }} {{ $vente->client?->nom }}</strong></div>
        <div>Tél : {{ $vente->client?->telephone }}</div>
        <div>Date : {{ $vente->created_at->format('d/m/Y H:i') }}</div>
        <div>Paiement :
          <strong>{{ match($vente->mode_paiement) {
            'orange_money' => 'Orange Money',
            'wero'         => 'Wero',
            'carte'        => 'Carte bancaire',
            default        => 'Sur place'
          } }}</strong>
        </div>
      </div>
    </div>

    <table>
      <thead><tr><th>Produit</th><th>Qté</th><th>Prix unit.</th><th>Total</th></tr></thead>
      <tbody>
        @foreach($vente->lignes as $l)
        <tr>
          <td>{{ $l->nom_produit }}</td>
          <td>{{ $l->quantite }}</td>
          <td>{{ number_format($l->prix_unitaire, 0, ',', ' ') }} {{ session('boutique.devise', 'FCFA') }}</td>
          <td><strong>{{ number_format($l->prix_unitaire * $l->quantite, 0, ',', ' ') }} {{ session('boutique.devise', 'FCFA') }}</strong></td>
        </tr>
        @endforeach
        <tr style="background:#FAFAFA">
          <td colspan="3" style="text-align:right;font-weight:700">TOTAL</td>
          <td style="font-weight:900;font-size:15px;color:var(--primary)">
            {{ number_format($vente->total_ttc, 0, ',', ' ') }} {{ session('boutique.devise', 'FCFA') }}
          </td>
        </tr>
      </tbody>
    </table>

    @if($vente->notes)
    <div style="background:#FFFBEB;border-left:3px solid var(--primary);padding:.75rem 1rem;border-radius:0 4px 4px 0;font-size:13px;color:#92400E;margin-top:1rem">
      <strong>Note :</strong> {{ $vente->notes }}
    </div>
    @endif
  </div>

  <div class="card" style="padding:1.25rem">
    <p style="font-size:11px;text-transform:uppercase;color:#888;margin-bottom:1rem">Changer le statut</p>
    <form method="POST" action="{{ route('admin.ventes.update', $vente) }}" class="f-grid">
      @csrf @method('PUT')
      <div class="fg">
        <select name="statut">
          @foreach(['en_attente'=>'En attente','confirmee'=>'Confirmée','prete'=>'Prête','livree'=>'Livrée','annulee'=>'Annulée'] as $k => $v)
          <option value="{{ $k }}" {{ $vente->statut === $k ? 'selected' : '' }}>{{ $v }}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="btn btn-gold" style="width:100%;justify-content:center">
        <i class="ti ti-check"></i> Mettre à jour
      </button>
    </form>
  </div>
</div>

@endsection