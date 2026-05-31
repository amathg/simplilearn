@extends('layouts.admin')
@section('title', 'Dépenses')
@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif

<div class="page-header">
  <h1>Dépenses</h1>
  <div style="display:flex;align-items:center;gap:.75rem">
    <div style="background:#fff;border:.5px solid #E5E5E0;border-radius:6px;padding:8px 16px;font-size:13px">
      Ce mois : <strong style="color:var(--red)">{{ number_format($total_mois,0,',',' ') }} {{ session('boutique.devise','FCFA') }}</strong>
    </div>
  </div>
</div>

<!-- Ajouter dépense -->
<div class="card" style="padding:1.5rem;margin-bottom:1.5rem">
  <h2 style="font-family:'Syne',sans-serif;font-weight:700;font-size:14px;margin-bottom:1rem">
    <i class="ti ti-plus" style="color:var(--primary)"></i> Nouvelle dépense
  </h2>
  <form method="POST" action="{{ route('admin.depenses.store') }}" style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr 1fr auto;gap:1rem;align-items:end">
    @csrf
    <div class="fg" style="margin:0"><label>Libellé *</label><input type="text" name="libelle" required placeholder="ex: Loyer mensuel"></div>
    <div class="fg" style="margin:0"><label>Montant *</label><input type="number" name="montant" min="0" step="0.01" required></div>
    <div class="fg" style="margin:0">
      <label>Catégorie</label>
      <select name="categorie_id">
        <option value="">— Aucune —</option>
        @foreach($categories as $cat)
        <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
        @endforeach
      </select>
    </div>
    <div class="fg" style="margin:0"><label>Date *</label><input type="date" name="date_depense" value="{{ date('Y-m-d') }}" required></div>
    <div class="fg" style="margin:0">
      <label>Paiement</label>
      <select name="mode_paiement">
        <option value="especes">Espèces</option>
        <option value="virement">Virement</option>
        <option value="cheque">Chèque</option>
        <option value="carte">Carte</option>
      </select>
    </div>
    <button type="submit" class="btn btn-gold"><i class="ti ti-plus"></i></button>
  </form>
</div>

<div class="card">
  <div class="card-head">
    <h2><i class="ti ti-wallet"></i> {{ $depenses->count() }} dépense{{ $depenses->count()>1?'s':'' }}</h2>
  </div>
  <table>
    <thead>
      <tr><th>Libellé</th><th>Catégorie</th><th>Date</th><th>Paiement</th><th>Montant</th><th></th></tr>
    </thead>
    <tbody>
      @forelse($depenses as $d)
      <tr>
        <td><strong>{{ $d->libelle }}</strong></td>
        <td><span class="badge badge-gray">{{ $d->categorie?->nom ?? '—' }}</span></td>
        <td style="font-size:12px;color:#888">{{ $d->date_depense->format('d/m/Y') }}</td>
        <td style="font-size:12px;color:#888">{{ ucfirst($d->mode_paiement) }}</td>
        <td><strong style="color:var(--red)">{{ number_format($d->montant,0,',',' ') }} {{ session('boutique.devise','FCFA') }}</strong></td>
        <td>
          <form method="POST" action="{{ route('admin.depenses.destroy', $d) }}" onsubmit="return confirm('Supprimer ?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-sm btn-red"><i class="ti ti-trash"></i></button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" style="text-align:center;padding:2rem;color:#aaa">Aucune dépense.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection