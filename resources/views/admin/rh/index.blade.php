@extends('layouts.admin')
@section('title', 'Employés')
@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif

<div class="page-header">
  <h1>Ressources Humaines</h1>
  <a href="{{ route('admin.employes.create') }}" class="btn btn-gold">
    <i class="ti ti-plus"></i> Ajouter un employé
  </a>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:1rem;margin-bottom:1.5rem">
  <div class="stat-card">
    <div class="stat-icon" style="background:#EFF6FF;color:#3B82F6"><i class="ti ti-users"></i></div>
    <div><span class="stat-val">{{ $employes->where('actif',true)->count() }}</span><span class="stat-lbl">Employés actifs</span></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#FFFBEB;color:#F59E0B"><i class="ti ti-coins"></i></div>
    <div><span class="stat-val">{{ number_format($employes->sum('salaire_base'),0,',',' ') }}</span><span class="stat-lbl">Masse salariale</span></div>
  </div>
</div>

<div class="card">
  <div class="card-head">
    <h2><i class="ti ti-users"></i> Liste des employés</h2>
  </div>
  <table>
    <thead>
      <tr><th>Matricule</th><th>Nom</th><th>Poste</th><th>Contrat</th><th>Salaire</th><th>Congés</th><th>Statut</th><th></th></tr>
    </thead>
    <tbody>
      @forelse($employes as $e)
      <tr>
        <td style="font-size:11px;color:#888">{{ $e->matricule }}</td>
        <td><strong>{{ $e->nom_complet }}</strong><br><span style="font-size:11px;color:#888">{{ $e->email }}</span></td>
        <td>{{ $e->poste }}</td>
        <td><span class="badge badge-info">{{ strtoupper($e->type_contrat) }}</span></td>
        <td><strong>{{ number_format($e->salaire_base,0,',',' ') }} {{ session('boutique.devise','FCFA') }}</strong></td>
        <td style="font-size:12px">{{ $e->conges_solde }} j restants</td>
        <td><span class="badge {{ $e->actif ? 'badge-success' : 'badge-gray' }}">{{ $e->actif ? 'Actif' : 'Inactif' }}</span></td>
        <td style="display:flex;gap:4px">
          <a href="{{ route('admin.employes.show', $e) }}" class="btn btn-xs btn-gold"><i class="ti ti-eye"></i></a>
          <a href="{{ route('admin.employes.edit', $e) }}" class="btn btn-xs" style="background:#F5F5F0;color:#666;border:.5px solid #DDD"><i class="ti ti-edit"></i></a>
        </td>
      </tr>
      @empty
      <tr><td colspan="8" style="text-align:center;padding:2rem;color:#aaa">Aucun employé.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection