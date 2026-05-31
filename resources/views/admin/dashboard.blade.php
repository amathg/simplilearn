@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon" style="background:#FFFBEB;color:#F59E0B"><i class="ti ti-clipboard-list"></i></div>
    <div><span class="stat-val">{{ $stats['commandes_attente'] }}</span><span class="stat-lbl">En attente</span></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#F0FDF4;color:#22C55E"><i class="ti ti-calendar-month"></i></div>
    <div><span class="stat-val">{{ $stats['commandes_mois'] }}</span><span class="stat-lbl">Commandes ce mois</span></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#EFF6FF;color:#3B82F6"><i class="ti ti-users"></i></div>
    <div><span class="stat-val">{{ $stats['nb_clients'] }}</span><span class="stat-lbl">Clients</span></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#FEF2F2;color:#EF4444"><i class="ti ti-package-off"></i></div>
    <div><span class="stat-val">{{ $stats['nb_ruptures'] }}</span><span class="stat-lbl">Ruptures</span></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#F5F5F0;color:#555"><i class="ti ti-coin"></i></div>
    <div><span class="stat-val">{{ number_format($stats['ca_mois'], 0, ',', ' ') }}</span><span class="stat-lbl">CA mois ({{ session('boutique.devise', 'FCFA') }})</span></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#F5F5F0;color:#555"><i class="ti ti-chart-bar"></i></div>
    <div><span class="stat-val">{{ number_format($stats['ca_total'], 0, ',', ' ') }}</span><span class="stat-lbl">CA total</span></div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 280px;gap:1.5rem;align-items:start">
  <div class="card">
    <div class="card-head">
      <h2><i class="ti ti-clipboard-list"></i> Dernières commandes</h2>
      <a href="{{ route('admin.ventes.index') }}" class="btn btn-gold btn-sm">Tout voir</a>
    </div>
    <table>
      <thead><tr><th>Référence</th><th>Client</th><th>Date</th><th>Total</th><th>Statut</th></tr></thead>
      <tbody>
        @forelse($dernieres_ventes as $v)
        <tr>
          <td><strong>{{ $v->reference }}</strong></td>
          <td>{{ $v->client?->prenom }} {{ $v->client?->nom }}</td>
          <td style="font-size:12px;color:#888">{{ $v->created_at->format('d/m/Y H:i') }}</td>
          <td><strong>{{ number_format($v->total_ttc, 0, ',', ' ') }} {{ session('boutique.devise', 'FCFA') }}</strong></td>
          <td>
            <span class="badge badge-{{ match($v->statut) {
              'en_attente' => 'warning',
              'confirmee'  => 'success',
              'prete'      => 'info',
              'annulee'    => 'danger',
              default      => 'gray'
            } }}">{{ $v->statut }}</span>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;padding:2rem;color:#aaa">Aucune commande.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="card">
    <div class="card-head"><h2><i class="ti ti-alert-triangle" style="color:#EF4444"></i> Stock faible</h2></div>
    @forelse($alertes_stock as $p)
    <div style="display:flex;align-items:center;justify-content:space-between;padding:.75rem 1rem;border-bottom:.5px solid #F7F7F5">
      <span style="font-size:13px">{{ Str::limit($p->nom, 25) }}</span>
      <span class="badge {{ $p->stock?->quantite == 0 ? 'badge-danger' : 'badge-warning' }}">
        {{ $p->stock?->quantite == 0 ? 'Rupture' : $p->stock?->quantite }}
      </span>
    </div>
    @empty
    <p style="padding:1rem;font-size:13px;color:#888">Aucun stock critique.</p>
    @endforelse
  </div>
</div>
@endsection