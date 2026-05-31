@extends('layouts.admin')
@section('title', 'Ventes à crédit')
@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif

<div class="page-header"><h1>Ventes à crédit</h1></div>

<div class="card">
  <table>
    <thead>
      <tr><th>Référence</th><th>Client</th><th>Total</th><th>Payé</th><th>Reste</th><th>Échéance</th><th>Statut</th><th></th></tr>
    </thead>
    <tbody>
      @forelse($credits as $c)
      <tr>
        <td><strong>{{ $c->vente?->reference }}</strong></td>
        <td>{{ $c->client?->prenom }} {{ $c->client?->nom }}</td>
        <td>{{ number_format($c->montant_total,0,',',' ') }}</td>
        <td style="color:#22C55E">{{ number_format($c->montant_paye,0,',',' ') }}</td>
        <td style="color:#EF4444"><strong>{{ number_format($c->montant_restant,0,',',' ') }} {{ session('boutique.devise','FCFA') }}</strong></td>
        <td style="font-size:12px;color:#888">{{ $c->date_echeance?->format('d/m/Y') ?? '—' }}</td>
        <td>
          <span class="badge badge-{{ match($c->statut) {'solde'=>'success','en_retard'=>'danger',default=>'warning'} }}">
            {{ ucfirst($c->statut) }}
          </span>
        </td>
        <td>
          @if($c->statut !== 'solde')
          <form method="POST" action="{{ route('admin.ventes.credits.payer', $c) }}" style="display:flex;gap:4px">
            @csrf
            <input type="number" name="montant" placeholder="Montant" min="0" max="{{ $c->montant_restant }}"
                   style="width:100px;border:.5px solid #DDD;border-radius:4px;padding:4px 8px;font-size:12px">
            <button type="submit" class="btn btn-xs btn-gold"><i class="ti ti-check"></i></button>
          </form>
          @endif
        </td>
      </tr>
      @empty
      <tr><td colspan="8" style="text-align:center;padding:2rem;color:#aaa">Aucune vente à crédit.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection