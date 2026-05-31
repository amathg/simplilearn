@extends('layouts.admin')
@section('title', 'Rapport ventes')
@section('content')

<div class="page-header">
  <h1>Rapport des ventes</h1>
  <a href="{{ route('admin.reporting.index') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD">
    <i class="ti ti-arrow-left"></i> Retour
  </a>
</div>

<div class="card">
  <table>
    <thead>
      <tr><th>Référence</th><th>Client</th><th>Date</th><th>Canal</th><th>Paiement</th><th>Total</th><th>Statut</th></tr>
    </thead>
    <tbody>
      @forelse($ventes as $v)
      <tr>
        <td><strong>{{ $v->reference }}</strong></td>
        <td>{{ $v->client?->prenom }} {{ $v->client?->nom }}</td>
        <td style="font-size:12px;color:#888">{{ $v->created_at->format('d/m/Y H:i') }}</td>
        <td><span class="badge badge-info" style="font-size:9px">{{ $v->canal }}</span></td>
        <td style="font-size:12px">{{ ucfirst($v->mode_paiement) }}</td>
        <td><strong>{{ number_format($v->total_ttc,0,',',' ') }} {{ $devise }}</strong></td>
        <td><span class="badge badge-{{ match($v->statut) {'en_attente'=>'warning','confirmee'=>'success','annulee'=>'danger',default=>'gray'} }}">{{ $v->statut }}</span></td>
      </tr>
      @empty
      <tr><td colspan="7" style="text-align:center;padding:2rem;color:#aaa">Aucune vente.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div style="padding:1rem">{{ $ventes->links() }}</div>
</div>
@endsection