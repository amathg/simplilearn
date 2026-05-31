@extends('layouts.admin')
@section('title', $employe->nom_complet)
@section('content')

<div style="margin-bottom:1rem">
  <a href="{{ route('admin.employes.index') }}" style="font-size:13px;color:#888;display:inline-flex;align-items:center;gap:6px">
    <i class="ti ti-arrow-left"></i> Retour
  </a>
</div>

<div style="display:grid;grid-template-columns:280px 1fr;gap:1.5rem;align-items:start">
  <!-- PROFIL -->
  <div class="card" style="padding:1.5rem;text-align:center">
    <div style="width:72px;height:72px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-weight:800;font-size:24px;color:#1A1A1A;margin:0 auto 1rem">
      {{ strtoupper(substr($employe->prenom,0,1).substr($employe->nom,0,1)) }}
    </div>
    <h2 style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.1rem">{{ $employe->nom_complet }}</h2>
    <p style="color:#888;font-size:13px;margin:.25rem 0">{{ $employe->poste }}</p>
    <span class="badge {{ $employe->actif ? 'badge-success' : 'badge-gray' }}">{{ $employe->actif ? 'Actif' : 'Inactif' }}</span>
    <div style="margin-top:1.25rem;font-size:12px;color:#888;text-align:left">
      <div style="padding:.5rem 0;border-bottom:.5px solid #F0F0EB">Matricule : <strong>{{ $employe->matricule }}</strong></div>
      <div style="padding:.5rem 0;border-bottom:.5px solid #F0F0EB">Contrat : <strong>{{ strtoupper($employe->type_contrat) }}</strong></div>
      <div style="padding:.5rem 0;border-bottom:.5px solid #F0F0EB">Embauche : <strong>{{ $employe->date_embauche->format('d/m/Y') }}</strong></div>
      <div style="padding:.5rem 0;border-bottom:.5px solid #F0F0EB">Salaire : <strong>{{ number_format($employe->salaire_base,0,',',' ') }} {{ session('boutique.devise','FCFA') }}</strong></div>
      <div style="padding:.5rem 0">Congés : <strong>{{ $employe->conges_solde }} jours restants</strong></div>
    </div>
    <a href="{{ route('admin.employes.edit', $employe) }}" class="btn btn-gold" style="width:100%;justify-content:center;margin-top:1rem">
      <i class="ti ti-edit"></i> Modifier
    </a>
  </div>

  <div>
    <!-- FICHES DE PAIE -->
    <div class="card" style="margin-bottom:1rem">
      <div class="card-head">
        <h2><i class="ti ti-coins"></i> Fiches de paie</h2>
        <a href="{{ route('admin.paie.index') }}" class="btn btn-sm btn-gold">Gérer</a>
      </div>
      <table>
        <thead><tr><th>Mois</th><th>Salaire</th><th>Primes</th><th>Déductions</th><th>Net</th><th>Statut</th></tr></thead>
        <tbody>
          @forelse($employe->fiches_paie->take(6) as $f)
          <tr>
            <td>{{ \Carbon\Carbon::create($f->annee,$f->mois)->format('M Y') }}</td>
            <td>{{ number_format($f->salaire_base,0,',',' ') }}</td>
            <td style="color:#22C55E">+{{ number_format($f->primes,0,',',' ') }}</td>
            <td style="color:#EF4444">-{{ number_format($f->avances_deduites+$f->cotisations,0,',',' ') }}</td>
            <td><strong>{{ number_format($f->net_a_payer,0,',',' ') }}</strong></td>
            <td><span class="badge badge-{{ $f->statut==='paye'?'success':($f->statut==='valide'?'info':'gray') }}">{{ $f->statut }}</span></td>
          </tr>
          @empty
          <tr><td colspan="6" style="text-align:center;padding:1rem;color:#aaa">Aucune fiche.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- AVANCES -->
    <div class="card">
      <div class="card-head">
        <h2><i class="ti ti-cash"></i> Avances & Primes</h2>
      </div>
      <table>
        <thead><tr><th>Type</th><th>Montant</th><th>Date</th><th>Statut</th></tr></thead>
        <tbody>
          @forelse($employe->avances->take(5) as $a)
          <tr>
            <td><span class="badge badge-info">{{ ucfirst($a->type) }}</span></td>
            <td><strong>{{ number_format($a->montant,0,',',' ') }}</strong></td>
            <td style="font-size:12px;color:#888">{{ $a->date_avance->format('d/m/Y') }}</td>
            <td><span class="badge badge-{{ $a->statut==='approuve'?'success':($a->statut==='rembourse'?'gray':'warning') }}">{{ $a->statut }}</span></td>
          </tr>
          @empty
          <tr><td colspan="4" style="text-align:center;padding:1rem;color:#aaa">Aucune avance.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection