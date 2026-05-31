@extends('layouts.admin')
@section('title', 'Fournisseurs')
@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif

<div class="page-header">
  <h1>Fournisseurs</h1>
  <a href="{{ route('admin.fournisseurs.create') }}" class="btn btn-gold">
    <i class="ti ti-plus"></i> Ajouter
  </a>
</div>

<div class="card">
  <div class="card-head">
    <h2><i class="ti ti-truck-delivery"></i> {{ $fournisseurs->count() }} fournisseur{{ $fournisseurs->count()>1?'s':'' }}</h2>
  </div>
  <table>
    <thead>
      <tr><th>Nom</th><th>Contact</th><th>Téléphone</th><th>Ville</th><th>Statut</th><th></th></tr>
    </thead>
    <tbody>
      @forelse($fournisseurs as $f)
      <tr>
        <td><strong>{{ $f->nom }}</strong><br><span style="font-size:11px;color:#888">{{ $f->email }}</span></td>
        <td>{{ $f->contact_nom ?? '—' }}</td>
        <td>{{ $f->telephone ?? '—' }}</td>
        <td>{{ $f->ville ?? '—' }}</td>
        <td><span class="badge {{ $f->actif ? 'badge-success' : 'badge-gray' }}">{{ $f->actif ? 'Actif' : 'Inactif' }}</span></td>
        <td style="display:flex;gap:6px">
          <a href="{{ route('admin.fournisseurs.edit', $f) }}" class="btn btn-sm btn-gold"><i class="ti ti-edit"></i></a>
          <form method="POST" action="{{ route('admin.fournisseurs.destroy', $f) }}" onsubmit="return confirm('Supprimer ?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-sm btn-red"><i class="ti ti-trash"></i></button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" style="text-align:center;padding:2rem;color:#aaa">Aucun fournisseur.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection