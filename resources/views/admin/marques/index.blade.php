@extends('layouts.admin')
@section('title', 'Marques')
@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif

<div class="page-header">
  <h1>Marques</h1>
</div>

<div style="display:grid;grid-template-columns:1fr 2fr;gap:1.5rem;align-items:start">
  <div class="card" style="padding:1.5rem">
    <h2 style="font-family:'Syne',sans-serif;font-weight:700;font-size:14px;margin-bottom:1rem">
      <i class="ti ti-plus" style="color:var(--primary)"></i> Nouvelle marque
    </h2>
    <form method="POST" action="{{ route('admin.marques.store') }}" class="f-grid">
      @csrf
      <div class="fg"><label>Nom *</label><input type="text" name="nom" required autofocus placeholder="ex: Samsung, Bosch..."></div>
      <button type="submit" class="btn btn-gold"><i class="ti ti-device-floppy"></i> Enregistrer</button>
    </form>
  </div>

  <div class="card">
    <div class="card-head">
      <h2><i class="ti ti-bookmark"></i> {{ $marques->count() }} marque{{ $marques->count()>1?'s':'' }}</h2>
    </div>
    <table>
      <thead><tr><th>Nom</th><th>Produits</th><th></th></tr></thead>
      <tbody>
        @forelse($marques as $m)
        <tr>
          <td><strong>{{ $m->nom }}</strong></td>
          <td>{{ $m->produits_count }} produit{{ $m->produits_count>1?'s':'' }}</td>
          <td>
            <form method="POST" action="{{ route('admin.marques.destroy', $m) }}" onsubmit="return confirm('Supprimer ?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-sm btn-red"><i class="ti ti-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="3" style="text-align:center;padding:2rem;color:#aaa">Aucune marque.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection