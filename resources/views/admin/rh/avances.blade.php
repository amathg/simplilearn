@extends('layouts.admin')
@section('title', 'Avances & Primes')
@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif

<div class="page-header"><h1>Avances & Primes</h1></div>

<div class="card" style="padding:1.5rem;margin-bottom:1.5rem">
  <form method="POST" action="{{ route('admin.avances.store') }}" style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr 2fr auto;gap:1rem;align-items:end">
    @csrf
    <div class="fg" style="margin:0">
      <label>Employé</label>
      <select name="employe_id" required>
        <option value="">— Choisir —</option>
        @foreach($employes as $e)
        <option value="{{ $e->id }}">{{ $e->nom_complet }}</option>
        @endforeach
      </select>
    </div>
    <div class="fg" style="margin:0">
      <label>Type</label>
      <select name="type">
        <option value="avance">Avance</option>
        <option value="prime">Prime</option>
        <option value="bonus">Bonus</option>
      </select>
    </div>
    <div class="fg" style="margin:0"><label>Montant</label><input type="number" name="montant" min="0" required></div>
    <div class="fg" style="margin:0"><label>Date</label><input type="date" name="date_avance" value="{{ date('Y-m-d') }}" required></div>
    <div class="fg" style="margin:0"><label>Motif</label><input type="text" name="motif" placeholder="Optionnel"></div>
    <button type="submit" class="btn btn-gold"><i class="ti ti-plus"></i></button>
  </form>
</div>

<div class="card">
  <div class="card-head"><h2><i class="ti ti-cash"></i> Historique</h2></div>
  <table>
    <thead><tr><th>Employé</th><th>Type</th><th>Montant</th><th>Date</th><th>Motif</th><th>Statut</th></tr></thead>
    <tbody>
      @forelse($avances as $a)
      <tr>
        <td><strong>{{ $a->employe->nom_complet }}</strong></td>
        <td><span class="badge badge-info">{{ ucfirst($a->type) }}</span></td>
        <td><strong>{{ number_format($a->montant,0,',',' ') }} {{ session('boutique.devise','FCFA') }}</strong></td>
        <td style="font-size:12px;color:#888">{{ $a->date_avance->format('d/m/Y') }}</td>
        <td style="font-size:12px;color:#888">{{ $a->motif ?? '—' }}</td>
        <td><span class="badge badge-{{ $a->statut==='approuve'?'success':($a->statut==='rembourse'?'gray':'warning') }}">{{ ucfirst($a->statut) }}</span></td>
      </tr>
      @empty
      <tr><td colspan="6" style="text-align:center;padding:2rem;color:#aaa">Aucune avance.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection