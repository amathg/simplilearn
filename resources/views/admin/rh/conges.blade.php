@extends('layouts.admin')
@section('title', 'Congés')
@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif

<div class="page-header"><h1>Gestion des congés</h1></div>

<div class="card" style="padding:1.5rem;margin-bottom:1.5rem">
  <h2 style="font-family:'Syne',sans-serif;font-weight:700;font-size:14px;margin-bottom:1rem">
    <i class="ti ti-plus" style="color:var(--primary)"></i> Nouvelle demande de congé
  </h2>
  <form method="POST" action="{{ route('admin.conges.store') }}" style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr 1fr auto;gap:1rem;align-items:end">
    @csrf
    <div class="fg" style="margin:0">
      <label>Employé</label>
      <select name="employe_id" required>
        <option value="">— Choisir —</option>
        @foreach(\App\Models\Employe::where('boutique_id',session('boutique_id'))->where('actif',true)->get() as $e)
        <option value="{{ $e->id }}">{{ $e->nom_complet }}</option>
        @endforeach
      </select>
    </div>
    <div class="fg" style="margin:0"><label>Du</label><input type="date" name="date_debut" required></div>
    <div class="fg" style="margin:0"><label>Au</label><input type="date" name="date_fin" required></div>
    <div class="fg" style="margin:0">
      <label>Type</label>
      <select name="type">
        <option value="annuel">Annuel</option>
        <option value="maladie">Maladie</option>
        <option value="maternite">Maternité</option>
        <option value="sans_solde">Sans solde</option>
        <option value="autre">Autre</option>
      </select>
    </div>
    <div class="fg" style="margin:0"><label>Motif</label><input type="text" name="motif" placeholder="Optionnel"></div>
    <button type="submit" class="btn btn-gold"><i class="ti ti-plus"></i></button>
  </form>
</div>

<div class="card">
  <div class="card-head">
    <h2><i class="ti ti-calendar-off"></i> {{ $conges->count() }} demande{{ $conges->count()>1?'s':'' }}</h2>
  </div>
  <table>
    <thead>
      <tr><th>Employé</th><th>Type</th><th>Du</th><th>Au</th><th>Jours</th><th>Statut</th><th></th></tr>
    </thead>
    <tbody>
      @forelse($conges as $c)
      <tr>
        <td><strong>{{ $c->employe->nom_complet }}</strong></td>
        <td><span class="badge badge-info">{{ ucfirst($c->type) }}</span></td>
        <td style="font-size:12px">{{ $c->date_debut->format('d/m/Y') }}</td>
        <td style="font-size:12px">{{ $c->date_fin->format('d/m/Y') }}</td>
        <td><strong>{{ $c->nb_jours }}j</strong></td>
        <td><span class="badge badge-{{ $c->statut==='approuve'?'success':($c->statut==='refuse'?'danger':'warning') }}">{{ ucfirst($c->statut) }}</span></td>
        <td>
          @if($c->statut === 'en_attente')
          <form method="POST" action="{{ route('admin.conges.approuver', $c) }}">
            @csrf
            <button type="submit" class="btn btn-xs btn-gold"><i class="ti ti-check"></i> Approuver</button>
          </form>
          @endif
        </td>
      </tr>
      @empty
      <tr><td colspan="7" style="text-align:center;padding:2rem;color:#aaa">Aucun congé.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection