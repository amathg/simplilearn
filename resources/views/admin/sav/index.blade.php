@extends('layouts.admin')
@section('title', 'SAV & Retours')
@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif

<div class="page-header"><h1>SAV & Retours</h1></div>

<div class="card" style="padding:1.5rem;margin-bottom:1.5rem">
  <h2 style="font-family:'Syne',sans-serif;font-weight:700;font-size:14px;margin-bottom:1rem">
    <i class="ti ti-plus" style="color:var(--primary)"></i> Nouveau dossier SAV
  </h2>
  <form method="POST" action="{{ route('admin.sav.store') }}" style="display:grid;grid-template-columns:1fr 1fr 2fr 2fr auto;gap:1rem;align-items:end">
    @csrf
    <div class="fg" style="margin:0">
      <label>Client</label>
      <select name="client_id">
        <option value="">— Optionnel —</option>
        @foreach($clients as $cl)
        <option value="{{ $cl->id }}">{{ $cl->prenom }} {{ $cl->nom }}</option>
        @endforeach
      </select>
    </div>
    <div class="fg" style="margin:0">
      <label>Type *</label>
      <select name="type" required>
        <option value="retour">Retour</option>
        <option value="reparation">Réparation</option>
        <option value="garantie">Garantie</option>
        <option value="reclamation">Réclamation</option>
      </select>
    </div>
    <div class="fg" style="margin:0"><label>Produit concerné *</label><input type="text" name="produit_concerne" required placeholder="Nom du produit"></div>
    <div class="fg" style="margin:0"><label>Description *</label><input type="text" name="description" required placeholder="Détails du problème"></div>
    <button type="submit" class="btn btn-gold"><i class="ti ti-plus"></i></button>
  </form>
</div>

<div class="card">
  <div class="card-head">
    <h2><i class="ti ti-headset"></i> {{ $savs->count() }} dossier{{ $savs->count()>1?'s':'' }}</h2>
  </div>
  <table>
    <thead>
      <tr><th>Référence</th><th>Client</th><th>Type</th><th>Produit</th><th>Date</th><th>Statut</th><th></th></tr>
    </thead>
    <tbody>
      @forelse($savs as $s)
      <tr>
        <td><strong>{{ $s->reference }}</strong></td>
        <td>{{ $s->client?->prenom }} {{ $s->client?->nom ?? '—' }}</td>
        <td><span class="badge badge-info">{{ ucfirst($s->type) }}</span></td>
        <td>{{ $s->produit_concerne }}</td>
        <td style="font-size:12px;color:#888">{{ $s->created_at->format('d/m/Y') }}</td>
        <td>
          <form method="POST" action="{{ route('admin.sav.update', $s) }}" style="display:flex;gap:4px;align-items:center">
            @csrf @method('PUT')
            <select name="statut" style="font-size:11px;border:.5px solid #DDD;border-radius:4px;padding:3px 6px" onchange="this.form.submit()">
              @foreach(['ouvert'=>'Ouvert','en_cours'=>'En cours','resolu'=>'Résolu','ferme'=>'Fermé'] as $k=>$v)
              <option value="{{ $k }}" {{ $s->statut===$k?'selected':'' }}>{{ $v }}</option>
              @endforeach
            </select>
          </form>
        </td>
        <td>
          <form method="POST" action="{{ route('admin.sav.destroy', $s) }}" onsubmit="return confirm('Supprimer ?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-xs btn-red"><i class="ti ti-trash"></i></button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="7" style="text-align:center;padding:2rem;color:#aaa">Aucun dossier SAV.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection