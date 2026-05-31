@extends('layouts.admin')
@section('title', 'Caisse')
@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif
@if($errors->any())
<div class="alert-ko"><i class="ti ti-alert-circle"></i> {{ $errors->first() }}</div>
@endif

<div class="page-header">
  <h1>Caisse</h1>
  <a href="{{ route('admin.caisse.historique') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD">
    <i class="ti ti-history"></i> Historique
  </a>
</div>

@if($session)
<!-- SESSION OUVERTE -->
<div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1.5rem;margin-bottom:1.5rem">
  <div class="stat-card">
    <div class="stat-icon" style="background:#F0FDF4;color:#22C55E"><i class="ti ti-coins"></i></div>
    <div><span class="stat-val">{{ number_format($session->total_especes,0,',',' ') }}</span><span class="stat-lbl">Espèces</span></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#EFF6FF;color:#3B82F6"><i class="ti ti-credit-card"></i></div>
    <div><span class="stat-val">{{ number_format($session->total_carte,0,',',' ') }}</span><span class="stat-lbl">Carte</span></div>
  </div>
  <div class="stat-card">
    <div class="stat-icon" style="background:#FFFBEB;color:#F59E0B"><i class="ti ti-device-mobile"></i></div>
    <div><span class="stat-val">{{ number_format($session->total_mobile,0,',',' ') }}</span><span class="stat-lbl">Mobile</span></div>
  </div>
</div>

<div class="card" style="padding:1.5rem">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem">
    <div>
      <h2 style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.1rem">
        <span class="badge badge-success">Session ouverte</span>
      </h2>
      <p style="font-size:13px;color:#888;margin-top:4px">
        Ouverte le {{ $session->ouverture_at->format('d/m/Y à H:i') }} par <strong>{{ session('admin_login') }}</strong>
      </p>
    </div>
    <div style="text-align:right">
      <div style="font-family:'Syne',sans-serif;font-size:1.5rem;font-weight:800;color:var(--primary)">
        {{ number_format($session->total_ventes,0,',',' ') }} {{ session('boutique.devise','FCFA') }}
      </div>
      <div style="font-size:12px;color:#888">Total des ventes</div>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.caisse.fermer') }}" class="f-grid">
    @csrf
    <div class="row2">
      <div class="fg">
        <label>Fond de caisse à la fermeture</label>
        <input type="number" name="fond_fermeture" min="0" step="0.01" placeholder="0">
      </div>
      <div class="fg">
        <label>Notes</label>
        <input type="text" name="notes" placeholder="Observations...">
      </div>
    </div>
    <button type="submit" class="btn btn-red" onclick="return confirm('Fermer la caisse ?')">
      <i class="ti ti-lock"></i> Fermer la caisse
    </button>
  </form>
</div>

@else
<!-- PAS DE SESSION -->
<div class="card" style="padding:2rem;text-align:center;margin-bottom:1.5rem">
  <i class="ti ti-cash-register" style="font-size:3rem;color:#DDD;display:block;margin-bottom:1rem"></i>
  <h2 style="font-family:'Syne',sans-serif;font-weight:700;margin-bottom:.5rem">Aucune session ouverte</h2>
  <p style="color:#888;font-size:14px;margin-bottom:2rem">Ouvrez la caisse pour commencer à enregistrer des ventes.</p>

  <form method="POST" action="{{ route('admin.caisse.ouvrir') }}" style="max-width:300px;margin:0 auto">
    @csrf
    <div class="fg" style="text-align:left;margin-bottom:1rem">
      <label>Fond de caisse initial</label>
      <input type="number" name="fond_ouverture" min="0" step="0.01" required placeholder="ex: 50000">
    </div>
    <button type="submit" class="btn btn-gold" style="width:100%;justify-content:center">
      <i class="ti ti-lock-open"></i> Ouvrir la caisse
    </button>
  </form>
</div>
@endif
@endsection