@extends('layouts.admin')
@section('title', 'Journal comptable')
@section('content')

<div class="page-header">
  <h1>Journal comptable</h1>
  <a href="{{ route('admin.comptabilite.index') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD">
    <i class="ti ti-arrow-left"></i> Retour
  </a>
</div>

<div class="card">
  <table>
    <thead>
      <tr><th>Date</th><th>Journal</th><th>Compte</th><th>Libellé</th><th>Débit</th><th>Crédit</th></tr>
    </thead>
    <tbody>
      @forelse($ecritures as $e)
      <tr>
        <td style="font-size:12px;color:#888">{{ $e->date_ecriture->format('d/m/Y') }}</td>
        <td><span class="badge badge-info">{{ $e->journal }}</span></td>
        <td><strong>{{ $e->compte?->numero }}</strong> — {{ $e->compte?->libelle }}</td>
        <td>{{ $e->libelle }}</td>
        <td style="color:#22C55E">{{ $e->debit > 0 ? number_format($e->debit,0,',',' ') : '—' }}</td>
        <td style="color:#EF4444">{{ $e->credit > 0 ? number_format($e->credit,0,',',' ') : '—' }}</td>
      </tr>
      @empty
      <tr><td colspan="6" style="text-align:center;padding:2rem;color:#aaa">Aucune écriture.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div style="padding:1rem">{{ $ecritures->links() }}</div>
</div>
@endsection