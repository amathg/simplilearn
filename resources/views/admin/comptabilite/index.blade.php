@extends('layouts.admin')
@section('title', 'Comptabilité')
@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif

<div class="page-header">
  <h1>Comptabilité</h1>
  <div style="display:flex;gap:.75rem">
    <a href="{{ route('admin.comptabilite.journal') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD"><i class="ti ti-book"></i> Journal</a>
    <a href="{{ route('admin.comptabilite.grand-livre') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD"><i class="ti ti-book-2"></i> Grand livre</a>
    <a href="{{ route('admin.comptabilite.balance') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD"><i class="ti ti-scale"></i> Balance</a>
    <a href="{{ route('admin.comptabilite.bilan') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD"><i class="ti ti-report"></i> Bilan</a>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem">
  <div class="stat-card">
    <div class="stat-icon" style="background:#F0FDF4;color:#22C55E"><i class="ti ti-trending-up"></i></div>
    <div><span class="stat-val">{{ number_format($total_debit,0,',',' ') }}</span><span class="stat-lbl">Total débit ({{ session('boutique.devise','FCFA') }})</span></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#FEF2F2;color:#EF4444"><i class="ti ti-trending-down"></i></div>
    <div><span class="stat-val">{{ number_format($total_credit,0,',',' ') }}</span><span class="stat-lbl">Total crédit</span></div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 2fr;gap:1.5rem;align-items:start">
  <div class="card" style="padding:1.5rem">
    <h2 style="font-family:'Syne',sans-serif;font-weight:700;font-size:14px;margin-bottom:1rem">
      <i class="ti ti-plus" style="color:var(--primary)"></i> Nouveau compte
    </h2>
    <form method="POST" action="{{ route('admin.comptes.store') }}" class="f-grid">
      @csrf
      <div class="fg"><label>Numéro *</label><input type="text" name="numero" required placeholder="ex: 411000"></div>
      <div class="fg"><label>Libellé *</label><input type="text" name="libelle" required placeholder="ex: Clients"></div>
      <div class="fg">
        <label>Type *</label>
        <select name="type" required>
          <option value="actif">Actif</option>
          <option value="passif">Passif</option>
          <option value="charge">Charge</option>
          <option value="produit">Produit</option>
          <option value="capitaux">Capitaux</option>
        </select>
      </div>
      <button type="submit" class="btn btn-gold"><i class="ti ti-device-floppy"></i> Créer</button>
    </form>
  </div>

  <div class="card">
    <div class="card-head">
      <h2><i class="ti ti-calculator"></i> Plan comptable — {{ $comptes->count() }} comptes</h2>
    </div>
    <table>
      <thead><tr><th>N°</th><th>Libellé</th><th>Type</th><th>Solde</th><th></th></tr></thead>
      <tbody>
        @forelse($comptes as $c)
        <tr>
          <td><strong>{{ $c->numero }}</strong></td>
          <td>{{ $c->libelle }}</td>
          <td><span class="badge badge-{{ match($c->type) {'actif'=>'success','passif'=>'danger','charge'=>'warning','produit'=>'info',default=>'gray'} }}">{{ ucfirst($c->type) }}</span></td>
          <td><strong>{{ number_format($c->solde,0,',',' ') }}</strong></td>
          <td>
            <form method="POST" action="{{ route('admin.comptes.destroy', $c) }}" onsubmit="return confirm('Supprimer ?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-xs btn-red"><i class="ti ti-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;padding:2rem;color:#aaa">Aucun compte. Créez votre plan comptable.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection