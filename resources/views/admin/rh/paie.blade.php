@extends('layouts.admin')
@section('title', 'Paie')
@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif

<div class="page-header"><h1>Fiches de paie</h1></div>

<div class="card" style="padding:1.5rem;margin-bottom:1.5rem">
  <h2 style="font-family:'Syne',sans-serif;font-weight:700;font-size:14px;margin-bottom:1rem">
    <i class="ti ti-plus" style="color:var(--primary)"></i> Générer une fiche de paie
  </h2>
  <form method="POST" action="{{ route('admin.paie.generer') }}" style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr 1fr 1fr auto;gap:1rem;align-items:end">
    @csrf
    <div class="fg" style="margin:0">
      <label>Employé</label>
      <select name="employe_id" required>
        <option value="">— Choisir —</option>
        @foreach($employes as $e)
        <option value="{{ $e->id }}">{{ $e->nom_complet }} ({{ number_format($e->salaire_base,0,',',' ') }})</option>
        @endforeach
      </select>
    </div>
    <div class="fg" style="margin:0">
      <label>Mois</label>
      <select name="mois">
        @for($m=1;$m<=12;$m++)
        <option value="{{ $m }}" {{ now()->month==$m?'selected':'' }}>{{ \Carbon\Carbon::create(null,$m)->format('F') }}</option>
        @endfor
      </select>
    </div>
    <div class="fg" style="margin:0"><label>Année</label><input type="number" name="annee" value="{{ date('Y') }}" required></div>
    <div class="fg" style="margin:0"><label>Primes</label><input type="number" name="primes" value="0" min="0"></div>
    <div class="fg" style="margin:0"><label>Heures sup.</label><input type="number" name="heures_sup" value="0" min="0"></div>
    <div class="fg" style="margin:0"><label>Cotisations</label><input type="number" name="cotisations" value="0" min="0"></div>
    <button type="submit" class="btn btn-gold"><i class="ti ti-calculator"></i></button>
  </form>
</div>

<div class="card">
  <div class="card-head">
    <h2><i class="ti ti-coins"></i> Dernières fiches générées</h2>
  </div>
  <table>
    <thead>
      <tr><th>Employé</th><th>Période</th><th>Salaire</th><th>Primes</th><th>Déductions</th><th>Net à payer</th><th>Statut</th></tr>
    </thead>
    <tbody>
      @forelse($fiches as $f)
      <tr>
        <td><strong>{{ $f->employe->nom_complet }}</strong></td>
        <td>{{ \Carbon\Carbon::create($f->annee,$f->mois)->format('F Y') }}</td>
        <td>{{ number_format($f->salaire_base,0,',',' ') }}</td>
        <td style="color:#22C55E">+{{ number_format($f->primes,0,',',' ') }}</td>
        <td style="color:#EF4444">-{{ number_format($f->avances_deduites+$f->cotisations,0,',',' ') }}</td>
        <td><strong>{{ number_format($f->net_a_payer,0,',',' ') }} {{ session('boutique.devise','FCFA') }}</strong></td>
        <td><span class="badge badge-{{ $f->statut==='paye'?'success':($f->statut==='valide'?'info':'gray') }}">{{ ucfirst($f->statut) }}</span></td>
      </tr>
      @empty
      <tr><td colspan="7" style="text-align:center;padding:2rem;color:#aaa">Aucune fiche.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection