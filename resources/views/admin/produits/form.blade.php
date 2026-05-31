@extends('layouts.admin')

@section('title', isset($produit) ? 'Modifier produit' : 'Nouveau produit')

@section('content')

<div class="page-header">
  <h1>{{ isset($produit) ? 'Modifier : '.$produit->nom : 'Nouveau produit' }}</h1>
  <a href="{{ route('admin.produits.index') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD">
    <i class="ti ti-arrow-left"></i> Retour
  </a>
</div>

@if($errors->any())
<div class="alert-ko"><i class="ti ti-alert-circle"></i> {{ $errors->first() }}</div>
@endif

<div class="card" style="padding:1.5rem">
  <form method="POST" action="{{ isset($produit) ? route('admin.produits.update', $produit) : route('admin.produits.store') }}" enctype="multipart/form-data" class="f-grid">
    @csrf
    @if(isset($produit)) @method('PUT') @endif

    <div class="row2">
      <div class="fg">
        <label>Nom *</label>
        <input type="text" name="nom" value="{{ old('nom', $produit->nom ?? '') }}" required autofocus>
      </div>
      <div class="fg">
        <label>Catégorie</label>
        <select name="categorie_id">
          <option value="">— Aucune —</option>
          @foreach($categories as $cat)
          <option value="{{ $cat->id }}" {{ old('categorie_id', $produit->categorie_id ?? '') == $cat->id ? 'selected' : '' }}>
            {{ $cat->nom }}
          </option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="fg">
      <label>Description</label>
      <textarea name="description" rows="3">{{ old('description', $produit->description ?? '') }}</textarea>
    </div>

    <div class="row3">
      <div class="fg">
        <label>Prix de vente *</label>
        <input type="number" name="prix_vente" value="{{ old('prix_vente', $produit->prix_vente ?? '') }}" min="0" required>
      </div>
      <div class="fg">
        <label>Prix d'achat</label>
        <input type="number" name="prix_achat" value="{{ old('prix_achat', $produit->prix_achat ?? 0) }}" min="0">
      </div>
      <div class="fg">
        <label>Promo (%)</label>
        <input type="number" name="promo" value="{{ old('promo', $produit->promo ?? 0) }}" min="0" max="99">
      </div>
    </div>

    <div class="row2">
      <div class="fg">
        <label>Stock</label>
        <input type="number" name="stock" value="{{ old('stock', $produit->stock?->quantite ?? 0) }}" min="0">
      </div>
      <div class="fg">
        <label>Icône (ex: ti-package)</label>
        <input type="text" name="icone" value="{{ old('icone', $produit->icone ?? 'ti-package') }}">
      </div>
    </div>

    <div class="fg">
      <label>Image</label>
      @if(isset($produit) && $produit->image)
      <img src="{{ Storage::url($produit->image) }}" style="height:60px;border-radius:4px;margin-bottom:.5rem;object-fit:cover">
      @endif
      <input type="file" name="image" accept="image/jpeg,image/png,image/webp">
    </div>

    <div style="display:flex;gap:1.5rem">
      <label style="display:flex;align-items:center;gap:6px;font-size:13px;cursor:pointer">
        <input type="checkbox" name="nouveau" {{ old('nouveau', $produit->nouveau ?? false) ? 'checked' : '' }} style="width:auto;accent-color:var(--primary)">
        Badge "Nouveau"
      </label>
      <label style="display:flex;align-items:center;gap:6px;font-size:13px;cursor:pointer">
        <input type="checkbox" name="visible" {{ old('visible', $produit->visible ?? true) ? 'checked' : '' }} style="width:auto;accent-color:var(--primary)">
        Visible sur la boutique
      </label>
    </div>

    <button type="submit" class="btn btn-gold">
      <i class="ti ti-device-floppy"></i> Enregistrer
    </button>
  </form>
</div>

@endsection