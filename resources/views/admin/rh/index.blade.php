@extends('layouts.admin')
@section('title', 'Employés')

@push('styles')
<style>
.anciennete-badge {
    display:inline-flex;align-items:center;gap:4px;
    background:#F0FDF4;color:#166534;
    border:.5px solid #BBF7D0;border-radius:20px;
    font-size:11px;font-weight:600;padding:2px 9px;
}
.modal-backdrop-rh {
    display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);
    z-index:200;align-items:center;justify-content:center;
}
.modal-rh {
    background:#fff;border-radius:14px;padding:1.75rem;
    width:460px;max-width:95vw;max-height:90vh;overflow-y:auto;
}
</style>
@endpush

@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif

<div class="page-header">
  <h1>Ressources Humaines</h1>
  <a href="{{ route('admin.employes.create') }}" class="btn btn-gold">
    <i class="ti ti-plus"></i> Ajouter un employé
  </a>
</div>

@php
  $devise  = session('boutique.devise', 'FCFA');
  $ancMoy  = $employes->filter(fn($e) => $e->date_embauche)
                      ->avg(fn($e) => now()->diffInYears($e->date_embauche));
@endphp

<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:1rem;margin-bottom:1.5rem">
  <div class="stat-card">
    <div class="stat-icon" style="background:#EFF6FF;color:#3B82F6"><i class="ti ti-users"></i></div>
    <div><span class="stat-val">{{ $employes->where('actif',true)->count() }}</span><span class="stat-lbl">Employés actifs</span></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#FFFBEB;color:#F59E0B"><i class="ti ti-coins"></i></div>
    <div><span class="stat-val">{{ number_format($employes->where('actif',true)->sum('salaire_base'),0,',',' ') }}</span><span class="stat-lbl">Masse salariale</span></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#F0FDF4;color:#22C55E"><i class="ti ti-calendar"></i></div>
    <div><span class="stat-val">{{ $ancMoy ? number_format($ancMoy, 1) : '—' }}</span><span class="stat-lbl">Ancienneté moyenne (ans)</span></div>
  </div>
</div>

<div class="card">
  <div class="card-head">
    <h2><i class="ti ti-users"></i> Liste des employés</h2>
  </div>
  <table>
    <thead>
      <tr>
        <th>Matricule</th><th>Nom</th><th>Poste</th><th>Contrat</th>
        <th>Salaire de base</th><th>Ancienneté</th><th>Congés</th><th>Statut</th><th></th>
      </tr>
    </thead>
    <tbody>
      @forelse($employes as $e)
      @php
        $embauche   = $e->date_embauche;
        $annees     = $embauche ? now()->diffInYears($embauche) : 0;
        $mois       = $embauche ? now()->diffInMonths($embauche) % 12 : 0;
        $prime_anc  = (int) round($e->salaire_base * $annees * 0.01);
        if ($annees > 0) {
            $anciennete = $annees . ' an' . ($annees > 1 ? 's' : '') . ($mois > 0 ? ' ' . $mois . ' mois' : '');
        } else {
            $anciennete = $mois . ' mois';
        }
        $nomJs      = addslashes($e->nom_complet);
      @endphp
      <tr>
        <td style="font-size:11px;color:#888">{{ $e->matricule }}</td>
        <td>
          <strong>{{ $e->nom_complet }}</strong><br>
          <span style="font-size:11px;color:#888">{{ $e->email }}</span>
        </td>
        <td>{{ $e->poste }}</td>
        <td><span class="badge badge-info">{{ strtoupper($e->type_contrat) }}</span></td>
        <td>
          <strong>{{ number_format($e->salaire_base,0,',',' ') }} {{ $devise }}</strong>
          @if($prime_anc > 0)
          <br><span style="font-size:11px;color:#22C55E">+ {{ number_format($prime_anc,0,',',' ') }} prime anc.</span>
          @endif
        </td>
        <td>
          @if($embauche)
          <span class="anciennete-badge"><i class="ti ti-clock" style="font-size:12px"></i> {{ $anciennete }}</span>
          <div style="font-size:10px;color:#aaa;margin-top:3px">Depuis le {{ $embauche->format('d/m/Y') }}</div>
          @else
          <span style="color:#ccc">—</span>
          @endif
        </td>
        <td style="font-size:12px">{{ $e->conges_solde }} j restants</td>
        <td><span class="badge {{ $e->actif ? 'badge-success' : 'badge-gray' }}">{{ $e->actif ? 'Actif' : 'Inactif' }}</span></td>
        <td style="display:flex;gap:4px;flex-wrap:wrap">
          <a href="{{ route('admin.employes.show', $e) }}" class="btn btn-xs btn-gold" title="Voir fiche"><i class="ti ti-eye"></i></a>
          <a href="{{ route('admin.employes.edit', $e) }}" class="btn btn-xs" style="background:#F5F5F0;color:#666;border:.5px solid #DDD" title="Modifier"><i class="ti ti-edit"></i></a>
          <button onclick="ouvrirPaie({{ $e->id }}, '{{ $nomJs }}', {{ $e->salaire_base }}, {{ $prime_anc }})"
                  class="btn btn-xs" style="background:#EFF6FF;color:#3B82F6;border:.5px solid #BFDBFE" title="Générer fiche de paie">
            <i class="ti ti-file-invoice"></i>
          </button>
        </td>
      </tr>
      @empty
      <tr><td colspan="9" style="text-align:center;padding:2rem;color:#aaa">Aucun employé.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

{{-- MODAL FICHE DE PAIE --}}
<div class="modal-backdrop-rh" id="modal-paie" onclick="if(event.target===this)fermerPaie()">
  <div class="modal-rh">
    <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem">
      <div style="width:38px;height:38px;background:#EFF6FF;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#3B82F6;font-size:20px">
        <i class="ti ti-file-invoice"></i>
      </div>
      <div>
        <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:1rem">Générer une fiche de paie</div>
        <div id="paie-employe-nom" style="font-size:12px;color:#888"></div>
      </div>
      <button type="button" onclick="fermerPaie()" style="margin-left:auto;background:none;border:none;font-size:20px;cursor:pointer;color:#ccc">×</button>
    </div>

    <form method="POST" action="{{ route('admin.paie.generer') }}">
      @csrf
      <input type="hidden" name="employe_id" id="paie-employe-id">

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-bottom:.875rem">
        <div class="fg" style="margin:0">
          <label>Mois</label>
          <select name="mois" style="width:100%" required>
            <option value="1"  {{ now()->month==1  ? 'selected' : '' }}>Janvier</option>
            <option value="2"  {{ now()->month==2  ? 'selected' : '' }}>Février</option>
            <option value="3"  {{ now()->month==3  ? 'selected' : '' }}>Mars</option>
            <option value="4"  {{ now()->month==4  ? 'selected' : '' }}>Avril</option>
            <option value="5"  {{ now()->month==5  ? 'selected' : '' }}>Mai</option>
            <option value="6"  {{ now()->month==6  ? 'selected' : '' }}>Juin</option>
            <option value="7"  {{ now()->month==7  ? 'selected' : '' }}>Juillet</option>
            <option value="8"  {{ now()->month==8  ? 'selected' : '' }}>Août</option>
            <option value="9"  {{ now()->month==9  ? 'selected' : '' }}>Septembre</option>
            <option value="10" {{ now()->month==10 ? 'selected' : '' }}>Octobre</option>
            <option value="11" {{ now()->month==11 ? 'selected' : '' }}>Novembre</option>
            <option value="12" {{ now()->month==12 ? 'selected' : '' }}>Décembre</option>
          </select>
        </div>
        <div class="fg" style="margin:0">
          <label>Année</label>
          <input type="number" name="annee" value="{{ now()->year }}" min="2020" max="2030" style="width:100%" required>
        </div>
      </div>

      <div style="background:#F9F9F6;border-radius:8px;padding:1rem;margin-bottom:.875rem;font-size:13px">
        <div style="font-weight:600;margin-bottom:.5rem;color:#888;font-size:11px;text-transform:uppercase;letter-spacing:.5px">Récapitulatif</div>
        <div style="display:flex;justify-content:space-between;margin-bottom:4px">
          <span>Salaire de base</span><strong id="paie-salaire-base-lbl"></strong>
        </div>
        <div style="display:flex;justify-content:space-between;margin-bottom:4px;color:#22C55E">
          <span>Prime ancienneté</span><strong id="paie-prime-anc-lbl"></strong>
        </div>
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-bottom:.875rem">
        <div class="fg" style="margin:0">
          <label>Primes</label>
          <input type="number" name="primes" id="paie-primes" min="0" step="100" value="0" oninput="recalcNet()" style="width:100%">
        </div>
        <div class="fg" style="margin:0">
          <label>Heures supplémentaires</label>
          <input type="number" name="heures_sup" id="paie-heures-sup" min="0" step="100" value="0" oninput="recalcNet()" style="width:100%">
        </div>
        <div class="fg" style="margin:0">
          <label>Avances déduites</label>
          <input type="number" name="avances_deduites" id="paie-avances" min="0" step="100" value="0" oninput="recalcNet()" style="width:100%">
        </div>
        <div class="fg" style="margin:0">
          <label>Cotisations sociales</label>
          <input type="number" name="cotisations" id="paie-cotisations" min="0" step="100" value="0" oninput="recalcNet()" style="width:100%">
        </div>
      </div>

      <div style="background:var(--dark);color:#fff;border-radius:8px;padding:1rem;margin-bottom:1rem;display:flex;justify-content:space-between;align-items:center">
        <span style="font-size:13px;opacity:.7">Net à payer</span>
        <span id="paie-net" style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.25rem;color:var(--primary)">0</span>
      </div>

      <div style="display:flex;gap:.5rem">
        <button type="button" onclick="fermerPaie()" class="btn" style="flex:1;background:#F5F5F0;border:.5px solid #DDD;color:#666">Annuler</button>
        <button type="submit" class="btn btn-gold" style="flex:2">
          <i class="ti ti-file-invoice"></i> Générer la fiche
        </button>
      </div>
    </form>
  </div>
</div>

@endsection

@push('scripts')
<script>
var _salaire  = 0;
var _primeAnc = 0;
var DEVISE    = "{{ session('boutique.devise', 'FCFA') }}";

function ouvrirPaie(id, nom, salaire, primeAnc) {
    _salaire  = salaire;
    _primeAnc = primeAnc;
    document.getElementById('paie-employe-id').value            = id;
    document.getElementById('paie-employe-nom').textContent      = nom;
    document.getElementById('paie-salaire-base-lbl').textContent = salaire.toLocaleString('fr-FR') + ' ' + DEVISE;
    document.getElementById('paie-prime-anc-lbl').textContent    = primeAnc.toLocaleString('fr-FR') + ' ' + DEVISE;
    document.getElementById('paie-primes').value      = primeAnc;
    document.getElementById('paie-heures-sup').value  = 0;
    document.getElementById('paie-avances').value     = 0;
    document.getElementById('paie-cotisations').value = 0;
    recalcNet();
    document.getElementById('modal-paie').style.display = 'flex';
}

function fermerPaie() {
    document.getElementById('modal-paie').style.display = 'none';
}

function recalcNet() {
    var primes    = parseFloat(document.getElementById('paie-primes').value)      || 0;
    var heuresSup = parseFloat(document.getElementById('paie-heures-sup').value)  || 0;
    var avances   = parseFloat(document.getElementById('paie-avances').value)     || 0;
    var cotis     = parseFloat(document.getElementById('paie-cotisations').value) || 0;
    var net = Math.max(0, _salaire + primes + heuresSup - avances - cotis);
    document.getElementById('paie-net').textContent = net.toLocaleString('fr-FR') + ' ' + DEVISE;
}
</script>
@endpush