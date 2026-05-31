@extends('layouts.admin')
@section('title', 'Commandes achat')
@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif

<div class="page-header">
  <h1>Commandes achat</h1>
  <a href="{{ route('admin.achats.create') }}" class="btn btn-gold">
    <i class="ti ti-plus"></i> Nouvelle facture
  </a>
</div>

<div class="card">
  <table>
    <thead>
      <tr><th>Référence</th><th>Fournisseur</th><th>Date</th><th>Montant TTC</th><th>Payé</th><th>Reste</th><th>Statut</th><th></th></tr>
    </thead>
    <tbody>
      @forelse($achats as $a)
      <tr>
        <td><strong>{{ $a->reference }}</strong><br><span style="font-size:11px;color:#888">{{ $a->numero_facture }}</span></td>
        <td>{{ $a->fournisseur?->nom }}</td>
        <td style="font-size:12px;color:#888">{{ $a->date_facture->format('d/m/Y') }}</td>
        <td><strong>{{ number_format($a->montant_ttc,0,',',' ') }}</strong></td>
        <td style="color:#22C55E">{{ number_format($a->montant_paye,0,',',' ') }}</td>
        <td style="color:#EF4444">{{ number_format($a->montant_reste,0,',',' ') }}</td>
        <td>
          <span class="badge badge-{{ match($a->statut) {
            'payee'      => 'success',
            'partielle'  => 'warning',
            'annulee'    => 'danger',
            default      => 'gray'
          } }}">{{ ucfirst($a->statut) }}</span>
        </td>
        <td style="display:flex;gap:4px">
          <a href="{{ route('admin.achats.show', $a) }}" class="btn btn-xs btn-gold"><i class="ti ti-eye"></i></a>
          <form method="POST" action="{{ route('admin.achats.destroy', $a) }}" onsubmit="return confirm('Supprimer ?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-xs btn-red"><i class="ti ti-trash"></i></button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="8" style="text-align:center;padding:2rem;color:#aaa">Aucune facture.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection