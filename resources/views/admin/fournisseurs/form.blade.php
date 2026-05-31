@extends('layouts.admin')
@section('title', isset($fournisseur) ? 'Modifier fournisseur' : 'Nouveau fournisseur')
@section('content')

<div class="page-header">
  <h1>{{ isset($fournisseur) ? 'Modifier : '.$fournisseur->nom : 'Nouveau fournisseur' }}</h1>
  <a href="{{ route('admin.fournisseurs.index') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD">
    <i class="ti ti-arrow-left"></i> Retour
  </a>
</div>

@if($errors->any())
<div class="alert-ko"><i class="ti ti-alert-circle"></i> {{ $errors->first() }}</div>
@endif

<div class="card" style="padding:1.5rem">
  <form method="POST" action="{{ isset($fournisseur) ? route('admin.fournisseurs.update', $fournisseur) : route('admin.fournisseurs.store') }}" class="f-grid">
    @csrf
    @if(isset($fournisseur)) @method('PUT') @endif
    <div class="row2">
      <div class="fg"><label>Nom *</label><input type="text" name="nom" value="{{ old('nom', $fournisseur->nom ?? '') }}" required autofocus></div>
      <div class="fg"><label>Contact</label><input type="text" name="contact_nom" value="{{ old('contact_nom', $fournisseur->contact_nom ?? '') }}"></div>
    </div>
    <div class="row2">
      <div class="fg"><label>Email</label><input type="email" name="email" value="{{ old('email', $fournisseur->email ?? '') }}"></div>
      <div class="fg"><label>Téléphone</label><input type="tel" name="telephone" value="{{ old('telephone', $fournisseur->telephone ?? '') }}"></div>
    </div>
    <div class="row2">
      <div class="fg"><label>Ville</label><input type="text" name="ville" value="{{ old('ville', $fournisseur->ville ?? '') }}"></div>
      <div class="fg"><label>Pays</label><input type="text" name="pays" value="{{ old('pays', $fournisseur->pays ?? 'Sénégal') }}"></div>
    </div>
    <div class="fg"><label>Adresse</label><input type="text" name="adresse" value="{{ old('adresse', $fournisseur->adresse ?? '') }}"></div>
    <div class="fg"><label>Numéro fiscal</label><input type="text" name="numero_fiscal" value="{{ old('numero_fiscal', $fournisseur->numero_fiscal ?? '') }}"></div>
    <button type="submit" class="btn btn-gold"><i class="ti ti-device-floppy"></i> Enregistrer</button>
  </form>
</div>
@endsection