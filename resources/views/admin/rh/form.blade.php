@extends('layouts.admin')
@section('title', isset($employe) ? 'Modifier employé' : 'Nouvel employé')
@section('content')

<div class="page-header">
  <h1>{{ isset($employe) ? 'Modifier : '.$employe->nom_complet : 'Nouvel employé' }}</h1>
  <a href="{{ route('admin.employes.index') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD">
    <i class="ti ti-arrow-left"></i> Retour
  </a>
</div>

@if($errors->any())
<div class="alert-ko"><i class="ti ti-alert-circle"></i> {{ $errors->first() }}</div>
@endif

<div class="card" style="padding:1.5rem">
  <form method="POST" action="{{ isset($employe) ? route('admin.employes.update', $employe) : route('admin.employes.store') }}" class="f-grid">
    @csrf
    @if(isset($employe)) @method('PUT') @endif
    <div class="row2">
      <div class="fg"><label>Prénom *</label><input type="text" name="prenom" value="{{ old('prenom', $employe->prenom ?? '') }}" required autofocus></div>
      <div class="fg"><label>Nom *</label><input type="text" name="nom" value="{{ old('nom', $employe->nom ?? '') }}" required></div>
    </div>
    <div class="row2">
      <div class="fg"><label>Email</label><input type="email" name="email" value="{{ old('email', $employe->email ?? '') }}"></div>
      <div class="fg"><label>Téléphone</label><input type="tel" name="telephone" value="{{ old('telephone', $employe->telephone ?? '') }}"></div>
    </div>
    <div class="row2">
      <div class="fg"><label>Poste *</label><input type="text" name="poste" value="{{ old('poste', $employe->poste ?? '') }}" required placeholder="ex: Caissier, Magasinier..."></div>
      <div class="fg">
        <label>Type de contrat</label>
        <select name="type_contrat">
          @foreach(['cdi'=>'CDI','cdd'=>'CDD','stage'=>'Stage','freelance'=>'Freelance'] as $k=>$v)
          <option value="{{ $k }}" {{ old('type_contrat', $employe->type_contrat ?? 'cdi') === $k ? 'selected' : '' }}>{{ $v }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="row2">
      <div class="fg"><label>Salaire de base *</label><input type="number" name="salaire_base" value="{{ old('salaire_base', $employe->salaire_base ?? '') }}" min="0" required></div>
      <div class="fg"><label>Date d'embauche *</label><input type="date" name="date_embauche" value="{{ old('date_embauche', isset($employe) ? $employe->date_embauche->format('Y-m-d') : '') }}" required></div>
    </div>
    <button type="submit" class="btn btn-gold"><i class="ti ti-device-floppy"></i> Enregistrer</button>
  </form>
</div>
@endsection