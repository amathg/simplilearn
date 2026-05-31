@extends('layouts.admin')
@section('title', 'Rôles & Permissions')
@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif

<div class="page-header"><h1>Rôles & Permissions</h1></div>

<div style="display:grid;grid-template-columns:1fr 2fr;gap:1.5rem;align-items:start">
  <div class="card" style="padding:1.5rem">
    <h2 style="font-family:'Syne',sans-serif;font-weight:700;font-size:14px;margin-bottom:1rem">
      <i class="ti ti-plus" style="color:var(--primary)"></i> Nouveau rôle
    </h2>
    <form method="POST" action="{{ route('admin.roles.store') }}" class="f-grid">
      @csrf
      <div class="fg"><label>Nom du rôle *</label><input type="text" name="nom" required placeholder="ex: Caissier, Comptable..."></div>
      <div class="fg"><label>Description</label><input type="text" name="description" placeholder="Optionnel"></div>
      <div class="fg">
        <label>Permissions</label>
        <div style="max-height:200px;overflow-y:auto;border:.5px solid #DDD;border-radius:6px;padding:.75rem">
          @foreach($permissions->groupBy('module') as $module => $perms)
          <div style="margin-bottom:.75rem">
            <div style="font-size:10px;text-transform:uppercase;color:#888;font-weight:700;margin-bottom:.375rem">{{ $module }}</div>
            @foreach($perms as $p)
            <label style="display:flex;align-items:center;gap:8px;font-size:12px;cursor:pointer;margin-bottom:3px">
              <input type="checkbox" name="permissions[]" value="{{ $p->id }}" style="accent-color:var(--primary)">
              {{ $p->nom }}
            </label>
            @endforeach
          </div>
          @endforeach
        </div>
      </div>
      <button type="submit" class="btn btn-gold"><i class="ti ti-device-floppy"></i> Créer le rôle</button>
    </form>
  </div>

  <div class="card">
    <div class="card-head"><h2><i class="ti ti-shield"></i> {{ $roles->count() }} rôle{{ $roles->count()>1?'s':'' }}</h2></div>
    <table>
      <thead><tr><th>Nom</th><th>Description</th><th>Permissions</th><th></th></tr></thead>
      <tbody>
        @forelse($roles as $r)
        <tr>
          <td><strong>{{ $r->nom }}</strong></td>
          <td style="font-size:12px;color:#888">{{ $r->description ?? '—' }}</td>
          <td style="font-size:12px;color:#888">{{ $r->permissions->count() }} permission{{ $r->permissions->count()>1?'s':'' }}</td>
          <td>
            <form method="POST" action="{{ route('admin.roles.destroy', $r) }}" onsubmit="return confirm('Supprimer ?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-xs btn-red"><i class="ti ti-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="4" style="text-align:center;padding:2rem;color:#aaa">Aucun rôle.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection