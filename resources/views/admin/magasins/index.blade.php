@extends('layouts.admin')
@section('title', 'Magasins')
@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif

<div class="page-header">
  <h1>Magasins & Dépôts</h1>
  <button onclick="document.getElementById('modal-magasin').style.display='flex'" class="btn btn-gold">
    <i class="ti ti-plus"></i> Ajouter
  </button>
</div>

<div class="card">
  <table>
    <thead>
      <tr><th>Nom</th><th>Ville</th><th>Téléphone</th><th>Type</th><th>Statut</th><th></th></tr>
    </thead>
    <tbody>
      @forelse($magasins as $m)
      <tr>
        <td><strong>{{ $m->nom }}</strong><br><span style="font-size:11px;color:#888">{{ $m->adresse }}</span></td>
        <td>{{ $m->ville ?? '—' }}</td>
        <td>{{ $m->telephone ?? '—' }}</td>
        <td><span class="badge {{ $m->principal ? 'badge-dark' : 'badge-info' }}">{{ $m->principal ? 'Principal' : 'Secondaire' }}</span></td>
        <td><span class="badge {{ $m->actif ? 'badge-success' : 'badge-gray' }}">{{ $m->actif ? 'Actif' : 'Inactif' }}</span></td>
        <td>
          <form method="POST" action="{{ route('admin.magasins.destroy', $m) }}" onsubmit="return confirm('Supprimer ?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-sm btn-red"><i class="ti ti-trash"></i></button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" style="text-align:center;padding:2rem;color:#aaa">Aucun magasin.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- MODAL -->
<div id="modal-magasin" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:100;align-items:center;justify-content:center">
  <div style="background:#fff;border-radius:12px;padding:2rem;width:100%;max-width:480px">
    <h2 style="font-family:'Syne',sans-serif;font-weight:700;margin-bottom:1.5rem">Nouveau magasin</h2>
    <form method="POST" action="{{ route('admin.magasins.store') }}" class="f-grid">
      @csrf
      <div class="fg"><label>Nom *</label><input type="text" name="nom" required autofocus></div>
      <div class="row2">
        <div class="fg"><label>Ville</label><input type="text" name="ville"></div>
        <div class="fg"><label>Téléphone</label><input type="tel" name="telephone"></div>
      </div>
      <div class="fg"><label>Adresse</label><input type="text" name="adresse"></div>
      <label style="display:flex;align-items:center;gap:8px;font-size:13px;cursor:pointer">
        <input type="checkbox" name="principal" style="width:auto;accent-color:var(--primary)">
        Magasin principal
      </label>
      <div style="display:flex;gap:.75rem;justify-content:flex-end">
        <button type="button" onclick="document.getElementById('modal-magasin').style.display='none'" class="btn" style="background:#F5F5F0;color:#666;border:.5px solid #DDD">Annuler</button>
        <button type="submit" class="btn btn-gold"><i class="ti ti-device-floppy"></i> Enregistrer</button>
      </div>
    </form>
  </div>
</div>
@endsection