@extends('layouts.admin')
@section('title', 'Inventaires')
@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif

<div class="page-header">
  <h1>Inventaires</h1>
  <a href="{{ route('admin.inventaires.create') }}" class="btn btn-gold">
    <i class="ti ti-plus"></i> Nouvel inventaire
  </a>
</div>

<div class="card">
  <table>
    <thead>
      <tr><th>Référence</th><th>Date</th><th>Statut</th><th>Produits</th><th></th></tr>
    </thead>
    <tbody>
      @forelse($inventaires as $inv)
      <tr>
        <td><strong>{{ $inv->reference }}</strong></td>
        <td>{{ $inv->date_inventaire->format('d/m/Y') }}</td>
        <td>
          <span class="badge badge-{{ match($inv->statut) {
            'valide'   => 'success',
            'en_cours' => 'warning',
            'annule'   => 'danger',
            default    => 'gray'
          } }}">{{ ucfirst($inv->statut) }}</span>
        </td>
        <td>{{ $inv->lignes->count() }} produits</td>
        <td style="display:flex;gap:6px">
          <a href="{{ route('admin.inventaires.show', $inv) }}" class="btn btn-sm btn-gold"><i class="ti ti-eye"></i></a>
          @if($inv->statut !== 'valide')
          <form method="POST" action="{{ route('admin.inventaires.destroy', $inv) }}" onsubmit="return confirm('Supprimer ?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-sm btn-red"><i class="ti ti-trash"></i></button>
          </form>
          @endif
        </td>
      </tr>
      @empty
      <tr><td colspan="5" style="text-align:center;padding:2rem;color:#aaa">Aucun inventaire.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection