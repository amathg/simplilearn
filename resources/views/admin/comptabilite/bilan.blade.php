@extends('layouts.admin')
@section('title', 'Bilan')
@section('content')

<div class="page-header">
  <h1>Bilan comptable</h1>
  <a href="{{ route('admin.comptabilite.index') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD">
    <i class="ti ti-arrow-left"></i> Retour
  </a>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem">
  <div class="card">
    <div class="card-head"><h2><i class="ti ti-trending-up" style="color:#22C55E"></i> ACTIF</h2></div>
    <table>
      <thead><tr><th>Compte</th><th>Libellé</th><th>Montant</th></tr></thead>
      <tbody>
        @php $total_actif = 0; @endphp
        @foreach($actifs as $c)
        @php $solde = $c->ecritures->sum('debit') - $c->ecritures->sum('credit'); $total_actif += $solde; @endphp
        <tr>
          <td>{{ $c->numero }}</td>
          <td>{{ $c->libelle }}</td>
          <td><strong>{{ number_format($solde,0,',',' ') }}</strong></td>
        </tr>
        @endforeach
        <tr style="background:#F0FDF4;font-weight:700">
          <td colspan="2">TOTAL ACTIF</td>
          <td style="color:#22C55E">{{ number_format($total_actif,0,',',' ') }}</td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="card">
    <div class="card-head"><h2><i class="ti ti-trending-down" style="color:#EF4444"></i> PASSIF</h2></div>
    <table>
      <thead><tr><th>Compte</th><th>Libellé</th><th>Montant</th></tr></thead>
      <tbody>
        @php $total_passif = 0; @endphp
        @foreach($passifs as $c)
        @php $solde = $c->ecritures->sum('credit') - $c->ecritures->sum('debit'); $total_passif += $solde; @endphp
        <tr>
          <td>{{ $c->numero }}</td>
          <td>{{ $c->libelle }}</td>
          <td><strong>{{ number_format($solde,0,',',' ') }}</strong></td>
        </tr>
        @endforeach
        <tr style="background:#FEF2F2;font-weight:700">
          <td colspan="2">TOTAL PASSIF</td>
          <td style="color:#EF4444">{{ number_format($total_passif,0,',',' ') }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
@endsection