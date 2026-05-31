@extends('layouts.admin')

@section('title', 'Commandes')

@section('content')

<div class="page-header">
  <h1>Commandes</h1>
</div>

<div class="card">
  <div class="card-head">
    <h2><i class="ti ti-clipboard-list"></i> {{ $ventes->count() }} commande{{ $ventes->count() > 1 ? 's' : '' }}</h2>
  </div>
  <table>
    <thead>
      <tr><th>Référence</th><th>Client</th><th>Date</th><th>Total</th><th>Paiement</th><th>Statut</th><th></th></tr>
    </thead>
    <tbody>
      @forelse($ventes as $v)
      <tr>
        <td><strong>{{ $v->reference }}</strong></td>
        <td>{{ $v->client?->prenom }} {{ $v->client?->nom }}<br>
          <span style="font-size:11px;color:#aaa">{{ $v->client?->telephone }}</span>
        </td>
        <td style="font-size:12px;color:#888">{{ $v->created_at->format('d/m/Y H:i') }}</td>
        <td><strong>{{ number_format($v->total_ttc, 0, ',', ' ') }} {{ session('boutique.devise', 'FCFA') }}</strong></td>
        <td>
          <span class="badge badge-info" style="font-size:9px">
            {{ match($v->mode_paiement) {
              'orange_money' => 'Orange Money',
              'wero'         => 'Wero',
              'carte'        => 'Carte',
              default        => 'Sur place'
            } }}
          </span>
        </td>
        <td>
          <span class="badge badge-{{ match($v->statut) {
            'en_attente' => 'warning',
            'confirmee'  => 'success',
            'prete'      => 'info',
            'livree'     => 'gray',
            'annulee'    => 'danger',
            default      => 'gray'
          } }}">{{ $v->statut }}</span>
        </td>
        <td>
          <a href="{{ route('admin.ventes.show', $v) }}" class="btn btn-sm btn-gold">
            <i class="ti ti-eye"></i> Voir
          </a>
        </td>
      </tr>
      @empty
      <tr><td colspan="7" style="text-align:center;padding:2rem;color:#aaa">Aucune commande.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

@endsection