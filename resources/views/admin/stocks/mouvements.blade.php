@extends('layouts.admin')
@section('title', 'Mouvements de stock')
@section('content')

<div class="page-header">
  <h1>Mouvements de stock</h1>
  <a href="{{ route('admin.stocks.index') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD">
    <i class="ti ti-arrow-left"></i> Retour
  </a>
</div>

<div class="card">
  <table>
    <thead>
      <tr><th>Date</th><th>Produit</th><th>Type</th><th>Quantité</th><th>Avant</th><th>Après</th><th>Motif</th><th>Par</th></tr>
    </thead>
    <tbody>
      @forelse($mouvements as $m)
      <tr>
        <td style="font-size:12px;color:#888">{{ $m->created_at->format('d/m/Y H:i') }}</td>
        <td><strong>{{ $m->produit?->nom }}</strong></td>
        <td>
          <span class="badge badge-{{ $m->type==='entree'?'success':($m->type==='sortie'?'danger':'info') }}">
            {{ ucfirst($m->type) }}
          </span>
        </td>
        <td><strong>{{ $m->type==='sortie'?'-':'+' }}{{ $m->quantite }}</strong></td>
        <td style="color:#888">{{ $m->stock_avant }}</td>
        <td><strong>{{ $m->stock_apres }}</strong></td>
        <td style="font-size:12px;color:#888">{{ $m->motif ?? '—' }}</td>
        <td style="font-size:12px;color:#888">{{ $m->admin?->login ?? '—' }}</td>
      </tr>
      @empty
      <tr><td colspan="8" style="text-align:center;padding:2rem;color:#aaa">Aucun mouvement.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection