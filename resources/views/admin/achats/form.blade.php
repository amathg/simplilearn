@extends('layouts.admin')
@section('title', 'Nouvelle facture fournisseur')
@section('content')

<div class="page-header">
  <h1>Nouvelle facture fournisseur</h1>
  <a href="{{ route('admin.achats.index') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD">
    <i class="ti ti-arrow-left"></i> Retour
  </a>
</div>

<div class="card" style="padding:1.5rem">
  <form method="POST" action="{{ route('admin.achats.store') }}" class="f-grid">
    @csrf
    <div class="row2">
      <div class="fg">
        <label>Fournisseur *</label>
        <select name="fournisseur_id" required>
          <option value="">— Choisir —</option>
          @foreach($fournisseurs as $f)
          <option value="{{ $f->id }}">{{ $f->nom }}</option>
          @endforeach
        </select>
      </div>
      <div class="fg"><label>N° facture fournisseur</label><input type="text" name="numero_facture" placeholder="ex: FA-2024-001"></div>
    </div>
    <div class="row2">
      <div class="fg"><label>Date facture *</label><input type="date" name="date_facture" value="{{ date('Y-m-d') }}" required></div>
      <div class="fg"><label>Date d'échéance</label><input type="date" name="date_echeance"></div>
    </div>
    <div class="row3">
      <div class="fg"><label>Montant HT</label><input type="number" name="montant_ht" value="0" min="0" step="0.01"></div>
      <div class="fg"><label>TVA</label><input type="number" name="montant_tva" value="0" min="0" step="0.01"></div>
      <div class="fg"><label>Montant TTC *</label><input type="number" name="montant_ttc" min="0" step="0.01" required></div>
    </div>
    <div class="fg"><label>Notes</label><input type="text" name="notes" placeholder="Observations..."></div>
    <button type="submit" class="btn btn-gold"><i class="ti ti-device-floppy"></i> Enregistrer</button>
  </form>
</div>
@endsection