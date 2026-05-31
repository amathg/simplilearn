@extends('layouts.admin')
@section('title', 'Rapport RH')
@section('content')

<div class="page-header">
  <h1>Rapport RH</h1>
  <a href="{{ route('admin.reporting.index') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD">
    <i class="ti ti-arrow-left"></i> Retour
  </a>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem">
  <div class="stat-card">
    <div class="stat-icon" style="background:#EFF6FF;color:#3B82F6"><i class="ti ti-users"></i></div>
    <div><span class="stat-val">{{ $employes->where('actif',true)->count() }}</span><span class="stat-lbl">Employés actifs</span></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#FFFBEB;color:#F59E0B"><i class="ti ti-coins"></i></div>
    <div><span class="stat-val">{{ number_format($masse_salariale,0,',',' ') }}</span><span class="stat-lbl">Masse salariale ({{ session('boutique.devise','FCFA') }})</span></div>
  </div>
</div>

<div class="card">
  <table>
    <thead><tr><th>Employé</th><th>Poste</th><th>Contrat</th><th>Salaire</th><th>Congés restants</th><th>Fiches paie</th></tr></thead>
    <tbody>
      @foreach($employes as $e)
      <tr>
        <td><strong>{{ $e->nom_complet }}</strong></td>
        <td>{{ $e->poste }}</td>
        <td><span class="badge badge-info">{{ strtoupper($e->type_contrat) }}</span></td>
        <td>{{ number_format($e->salaire_base,0,',',' ') }} {{ session('boutique.devise','FCFA') }}</td>
        <td>{{ $e->conges_solde }}j</td>
        <td>{{ $e->fiches_paie->count() }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection