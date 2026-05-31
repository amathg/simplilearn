@extends('layouts.admin')
@section('title', 'Grand livre')
@section('content')

<div class="page-header">
  <h1>Grand livre</h1>
  <a href="{{ route('admin.comptabilite.index') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD">
    <i class="ti ti-arrow-left"></i> Retour
  </a>
</div>

@foreach($comptes as $c)
@if($c->ecritures->count() > 0)
<div class="card" style="margin-bottom:1rem">
  <div class="card-head">
    <h2><strong>{{ $c->numero }}</strong> — {{ $c->libelle }}</h2>
    <span>Solde : <strong>{{ number_format($c->solde,0,',',' ') }} {{ session('boutique.devise','FCFA') }}</strong></span>
  </div>
  <table>
    <thead><tr><th>Date</th><th>Libellé</th><th>Débit</th><th>Crédit</th></tr></thead>
    <tbody>
      @foreach($c->ecritures as $e)
      <tr>
        <td style="font-size:12px;color:#888">{{ $e->date_ecriture->format('d/m/Y') }}</td>
        <td>{{ $e->libelle }}</td>
        <td style="color:#22C55E">{{ $e->debit > 0 ? number_format($e->debit,0,',',' ') : '—' }}</td>
        <td style="color:#EF4444">{{ $e->credit > 0 ? number_format($e->credit,0,',',' ') : '—' }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endif
@endforeach

@if($comptes->every(fn($c) => $c->ecritures->count() === 0))
<div class="card" style="padding:3rem;text-align:center;color:#aaa">
  <i class="ti ti-book-off" style="font-size:3rem;display:block;margin-bottom:1rem"></i>
  <p>Aucune écriture comptable.</p>
</div>
@endif
@endsection