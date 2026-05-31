@extends('layouts.admin')
@section('title', 'Rapport financier')
@section('content')

<div class="page-header">
  <h1>Rapport financier</h1>
  <a href="{{ route('admin.reporting.index') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD">
    <i class="ti ti-arrow-left"></i> Retour
  </a>
</div>

<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1.5rem">
  <div class="stat-card">
    <div class="stat-icon" style="background:#F0FDF4;color:#22C55E"><i class="ti ti-trending-up"></i></div>
    <div><span class="stat-val">{{ number_format($ca_mois,0,',',' ') }}</span><span class="stat-lbl">CA ce mois ({{ $devise }})</span></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#FEF2F2;color:#EF4444"><i class="ti ti-trending-down"></i></div>
    <div><span class="stat-val">{{ number_format($depenses_mois,0,',',' ') }}</span><span class="stat-lbl">Dépenses ce mois</span></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:{{ $benefice>=0?'#F0FDF4':'#FEF2F2' }};color:{{ $benefice>=0?'#22C55E':'#EF4444' }}"><i class="ti ti-chart-pie"></i></div>
    <div><span class="stat-val" style="color:{{ $benefice>=0?'#22C55E':'#EF4444' }}">{{ number_format($benefice,0,',',' ') }}</span><span class="stat-lbl">Bénéfice net</span></div>
  </div>
</div>

<div class="card">
  <div class="card-head"><h2><i class="ti ti-wallet"></i> Dépenses par catégorie</h2></div>
  <table>
    <thead><tr><th>Catégorie</th><th>Nb dépenses</th><th>Total</th></tr></thead>
    <tbody>
      @forelse($depenses_par_cat as $cat => $depenses)
      <tr>
        <td><strong>{{ $cat ?? 'Sans catégorie' }}</strong></td>
        <td>{{ $depenses->count() }}</td>
        <td><strong style="color:var(--red)">{{ number_format($depenses->sum('montant'),0,',',' ') }} {{ $devise }}</strong></td>
      </tr>
      @empty
      <tr><td colspan="3" style="text-align:center;padding:2rem;color:#aaa">Aucune dépense ce mois.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection