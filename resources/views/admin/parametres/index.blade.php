@extends('layouts.admin')
@section('title', 'Paramètres')
@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif

<div class="page-header"><h1>Paramètres</h1></div>

<div style="display:grid;grid-template-columns:1fr 280px;gap:1.5rem;align-items:start">
  <div class="card" style="padding:1.5rem">
    <form method="POST" action="{{ route('admin.parametres.update') }}" enctype="multipart/form-data" class="f-grid">
      @csrf
      <h2 style="font-family:'Syne',sans-serif;font-weight:700;font-size:14px;margin-bottom:.5rem">Informations boutique</h2>
      <div class="row2">
        <div class="fg"><label>Nom de la boutique *</label><input type="text" name="nom" value="{{ old('nom', $boutique->nom) }}" required></div>
        <div class="fg"><label>Email</label><input type="email" name="email" value="{{ old('email', $boutique->email) }}"></div>
      </div>
      <div class="row2">
        <div class="fg"><label>Téléphone</label><input type="tel" name="telephone" value="{{ old('telephone', $boutique->telephone) }}"></div>
        <div class="fg"><label>Ville</label><input type="text" name="ville" value="{{ old('ville', $boutique->ville) }}"></div>
      </div>
      <div class="fg"><label>Adresse</label><input type="text" name="adresse" value="{{ old('adresse', $boutique->adresse) }}"></div>
      <div class="fg"><label>Description</label><input type="text" name="description" value="{{ old('description', $boutique->description) }}"></div>
      <div class="row2">
        <div class="fg"><label>Devise</label>
          <select name="devise">
            @foreach(['FCFA','EUR','USD','MAD','XOF'] as $dev)
            <option value="{{ $dev }}" {{ $boutique->devise === $dev ? 'selected' : '' }}>{{ $dev }}</option>
            @endforeach
          </select>
        </div>
        <div class="fg"><label>Pays</label><input type="text" name="pays" value="{{ old('pays', $boutique->pays) }}"></div>
      </div>
      <h2 style="font-family:'Syne',sans-serif;font-weight:700;font-size:14px;margin-bottom:.5rem;margin-top:.5rem">Apparence</h2>
      <div class="row2">
        <div class="fg"><label>Couleur primaire</label><input type="color" name="couleur_primaire" value="{{ $boutique->couleur_primaire }}"></div>
        <div class="fg"><label>Couleur secondaire</label><input type="color" name="couleur_secondaire" value="{{ $boutique->couleur_secondaire }}"></div>
      </div>
      <div class="fg">
        <label>Logo</label>
        @if($boutique->logo)
        <img src="{{ Storage::url($boutique->logo) }}" style="height:50px;border-radius:4px;margin-bottom:.5rem;object-fit:cover">
        @endif
        <input type="file" name="logo" accept="image/*">
      </div>
      <button type="submit" class="btn btn-gold"><i class="ti ti-device-floppy"></i> Enregistrer</button>
    </form>
  </div>

  <div class="card" style="padding:1.25rem">
    <h2 style="font-family:'Syne',sans-serif;font-weight:700;font-size:13px;margin-bottom:1rem">Mon plan</h2>
    <div style="background:var(--light);border-radius:6px;padding:1rem;text-align:center">
      <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.25rem;color:var(--primary)">{{ $boutique->plan->nom }}</div>
      <div style="font-size:12px;color:#888;margin-top:3px">{{ $boutique->plan->description }}</div>
      <div style="font-size:11px;color:#888;margin-top:.75rem">
        <div>{{ $boutique->plan->nb_produits == -1 ? 'Produits illimités' : $boutique->plan->nb_produits.' produits max' }}</div>
        <div>{{ $boutique->plan->nb_employes == -1 ? 'Employés illimités' : $boutique->plan->nb_employes.' employés max' }}</div>
      </div>
      <div style="margin-top:1rem;font-size:11px;color:#888">
        Statut : <span class="badge badge-success">{{ ucfirst($boutique->statut) }}</span>
      </div>
      @if($boutique->trial_fin)
      <div style="font-size:11px;color:#888;margin-top:.5rem">
        Période d'essai jusqu'au {{ $boutique->trial_fin->format('d/m/Y') }}
      </div>
      @endif
    </div>
    <a href="{{ route('boutique.index', $boutique->slug) }}" target="_blank" class="btn btn-gold" style="width:100%;justify-content:center;margin-top:1rem">
      <i class="ti ti-external-link"></i> Voir ma boutique
    </a>
  </div>
</div>
@endsection