@extends('layouts.admin')
@section('title', 'Balance')
@section('content')

<div class="page-header">
  <h1>Balance des comptes</h1>
  <a href="{{ route('admin.comptabilite.index') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD">
    <i class="ti ti-arrow-left"></i> Retour
  </a>
</div>

<div class="card">
  <table>
    <thead>
      <tr><th>N° Compte</th><th>Libellé</th><th>Total Débit</th><th>Total Crédit</th><th>Solde Débiteur</th><th>Solde Créditeur</th></tr>
    </thead>
    <tbody>
      @php $tot_d = 0; $tot_c = 0; @endphp
      @foreach($comptes as $c)
      @php
        $debit  = $c->ecritures->sum('debit');
        $credit = $c->ecritures->sum('credit');
        $solde  = $debit - $credit;
        $tot_d += $debit; $tot_c += $credit;
      @endphp
      @if($debit > 0 || $credit > 0)
      <tr>
        <td><strong>{{ $c->numero }}</strong></td>
        <td>{{ $c->libelle }}</td>
        <td>{{ number_format($debit,0,',',' ') }}</td>
        <td>{{ number_format($credit,0,',',' ') }}</td>
        <td style="color:#22C55E">{{ $solde > 0 ? number_format($solde,0,',',' ') : '—' }}</td>
        <td style="color:#EF4444">{{ $solde < 0 ? number_format(abs($solde),0,',',' ') : '—' }}</td>
      </tr>
      @endif
      @endforeach
      <tr style="background:#F5F5F0;font-weight:700">
        <td colspan="2">TOTAUX</td>
        <td>{{ number_format($tot_d,0,',',' ') }}</td>
        <td>{{ number_format($tot_c,0,',',' ') }}</td>
        <td colspan="2"></td>
      </tr>
    </tbody>
  </table>
</div>
@endsection