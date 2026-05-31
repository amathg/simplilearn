@extends('layouts.admin')
@section('title', 'Reporting & KPI')
@section('content')

<div class="page-header">
  <h1>Reporting & KPI</h1>
  <div style="display:flex;gap:.5rem">
    <a href="{{ route('admin.reporting.ventes') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD">Ventes</a>
    <a href="{{ route('admin.reporting.stocks') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD">Stocks</a>
    <a href="{{ route('admin.reporting.finances') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD">Finances</a>
    <a href="{{ route('admin.reporting.rh') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD">RH</a>
  </div>
</div>

<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon" style="background:#FFFBEB;color:#F59E0B"><i class="ti ti-chart-bar"></i></div>
    <div><span class="stat-val">{{ number_format($stats['ca_mois'],0,',',' ') }}</span><span class="stat-lbl">CA ce mois ({{ $devise }})</span></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#F0FDF4;color:#22C55E"><i class="ti ti-receipt"></i></div>
    <div><span class="stat-val">{{ $stats['nb_ventes'] }}</span><span class="stat-lbl">Total commandes</span></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#EFF6FF;color:#3B82F6"><i class="ti ti-users"></i></div>
    <div><span class="stat-val">{{ $stats['nb_clients'] }}</span><span class="stat-lbl">Clients</span></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#FEF2F2;color:#EF4444"><i class="ti ti-wallet"></i></div>
    <div><span class="stat-val">{{ number_format($stats['depenses_mois'],0,',',' ') }}</span><span class="stat-lbl">Dépenses ce mois</span></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#F5F5F0;color:#555"><i class="ti ti-package"></i></div>
    <div><span class="stat-val">{{ $stats['nb_produits'] }}</span><span class="stat-lbl">Produits</span></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#F5F5F0;color:#555"><i class="ti ti-users-group"></i></div>
    <div><span class="stat-val">{{ $stats['nb_employes'] }}</span><span class="stat-lbl">Employés</span></div>
  </div>
</div>

<!-- CA PAR MOIS -->
<div class="card">
  <div class="card-head">
    <h2><i class="ti ti-chart-line"></i> Chiffre d'affaires — 12 derniers mois</h2>
  </div>
  <div style="padding:1.5rem">
    @php $max = max(array_column($ca_mois, 'ca')) ?: 1; @endphp
    <div style="display:flex;align-items:flex-end;gap:.5rem;height:160px">
      @foreach($ca_mois as $m)
      @php $h = max(4, ($m['ca'] / $max) * 150); @endphp
      <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:4px">
        <div style="font-size:9px;color:#888">{{ number_format($m['ca']/1000,0) }}k</div>
        <div style="width:100%;background:var(--primary);border-radius:3px 3px 0 0;height:{{ $h }}px;transition:height .3s" title="{{ $m['mois'] }}: {{ number_format($m['ca'],0,',',' ') }} {{ $devise }}"></div>
        <div style="font-size:9px;color:#888;white-space:nowrap">{{ $m['mois'] }}</div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection