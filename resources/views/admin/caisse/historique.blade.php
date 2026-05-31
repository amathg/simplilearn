@extends('layouts.admin')
@section('title', 'Historique caisse')
@section('content')

<div class="page-header">
  <h1>Historique des sessions</h1>
  <a href="{{ route('admin.caisse.index') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD">
    <i class="ti ti-arrow-left"></i> Retour
  </a>
</div>

<div class="card">
  <table>
    <thead>
      <tr><th>Ouverture</th><th>Fermeture</th><th>Caissier</th><th>Fond initial</th><th>Espèces</th><th>Carte</th><th>Mobile</th><th>Total ventes</th><th>Statut</th></tr>
    </thead>
    <tbody>
      @forelse($sessions as $s)
      <tr>
        <td style="font-size:12px">{{ $s->ouverture_at->format('d/m/Y H:i') }}</td>
        <td style="font-size:12px;color:#888">{{ $s->fermeture_at?->format('d/m/Y H:i') ?? '—' }}</td>
        <td>{{ $s->admin?->login }}</td>
        <td>{{ number_format($s->fond_ouverture,0,',',' ') }}</td>
        <td>{{ number_format($s->total_especes,0,',',' ') }}</td>
        <td>{{ number_format($s->total_carte,0,',',' ') }}</td>
        <td>{{ number_format($s->total_mobile,0,',',' ') }}</td>
        <td><strong>{{ number_format($s->total_ventes,0,',',' ') }} {{ session('boutique.devise','FCFA') }}</strong></td>
        <td><span class="badge badge-{{ $s->statut==='ouverte'?'success':'gray' }}">{{ ucfirst($s->statut) }}</span></td>
      </tr>
      @empty
      <tr><td colspan="9" style="text-align:center;padding:2rem;color:#aaa">Aucune session.</td></tr>
      @endforelse
    </tbody>
  </table>
  <div style="padding:1rem">{{ $sessions->links() }}</div>
</div>
@endsection