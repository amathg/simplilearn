@extends('layouts.admin')
@section('title', 'Livraisons')
@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif

<div class="page-header"><h1>Livraisons</h1></div>

<div class="card">
  <div class="card-head">
    <h2><i class="ti ti-truck"></i> {{ $livraisons->count() }} livraison{{ $livraisons->count()>1?'s':'' }}</h2>
  </div>
  <table>
    <thead>
      <tr><th>Commande</th><th>Client</th><th>Adresse</th><th>Livreur</th><th>Statut</th><th></th></tr>
    </thead>
    <tbody>
      @forelse($livraisons as $l)
      <tr>
        <td><strong>{{ $l->vente?->reference }}</strong></td>
        <td>{{ $l->vente?->client?->prenom }} {{ $l->vente?->client?->nom }}</td>
        <td style="font-size:12px;color:#888">{{ \Illuminate\Support\Str::limit($l->adresse_livraison,30) }}</td>
        <td>{{ $l->livreur?->nom_complet ?? '—' }}</td>
        <td>
          <span class="badge badge-{{ match($l->statut) {
            'livree'     => 'success',
            'en_cours'   => 'info',
            'assignee'   => 'warning',
            'echouee'    => 'danger',
            'annulee'    => 'danger',
            default      => 'gray'
          } }}">{{ ucfirst(str_replace('_',' ',$l->statut)) }}</span>
        </td>
        <td>
          <form method="POST" action="{{ route('admin.livraisons.update', $l) }}" style="display:flex;gap:4px">
            @csrf @method('PUT')
            <select name="statut" style="font-size:11px;border:.5px solid #DDD;border-radius:4px;padding:3px 6px" onchange="this.form.submit()">
              @foreach(['en_attente'=>'En attente','assignee'=>'Assignée','en_cours'=>'En cours','livree'=>'Livrée','echouee'=>'Échouée','annulee'=>'Annulée'] as $k=>$v)
              <option value="{{ $k }}" {{ $l->statut===$k?'selected':'' }}>{{ $v }}</option>
              @endforeach
            </select>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="6" style="text-align:center;padding:2rem;color:#aaa">Aucune livraison.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection