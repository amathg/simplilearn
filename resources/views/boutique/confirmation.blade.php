<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Commande confirmée — {{ $boutique->nom }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/tabler-icons/tabler-icons.min.css">
  <style>
    :root{--primary:{{ $boutique->couleur_primaire ?? '#F5B72E' }};--secondary:{{ $boutique->couleur_secondaire ?? '#1A1A1A' }};--radius:8px}
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'DM Sans',sans-serif;background:#F5F5F0;color:#1A1A1A}
    a{text-decoration:none;color:inherit}
    nav{background:var(--secondary);padding:.875rem 1.5rem;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50}
    .nav-logo{font-family:'Syne',sans-serif;font-weight:800;font-size:16px;color:var(--primary)}
    .main{max-width:600px;margin:3rem auto;padding:0 1.5rem;text-align:center}
    .check-circle{width:80px;height:80px;background:#22C55E;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;font-size:36px;color:#fff}
    .title{font-family:'Syne',sans-serif;font-weight:800;font-size:1.75rem;margin-bottom:.5rem}
    .subtitle{color:#888;font-size:14px;margin-bottom:2rem}
    .card{background:#fff;border-radius:var(--radius);border:.5px solid #E5E5E0;padding:1.5rem;text-align:left;margin-bottom:1rem}
    .row{display:flex;justify-content:space-between;font-size:13px;padding:.5rem 0;border-bottom:.5px solid #F7F7F5}
    .row:last-child{border-bottom:none}
    .row-key{color:#888}
    .row-val{font-weight:600}
    .pay-info{background:#FFFBEB;border:.5px solid #F5B72E;border-radius:var(--radius);padding:1rem;margin-top:1rem;font-size:13px;text-align:left}
    .pay-info strong{display:block;margin-bottom:.375rem}
    .btn-back{display:inline-flex;align-items:center;gap:8px;background:var(--primary);color:#1A1A1A;padding:12px 24px;border-radius:var(--radius);font-weight:700;font-size:13px;margin-top:1.5rem;transition:.2s}
    .btn-back:hover{opacity:.85}
    footer{background:var(--secondary);color:rgba(255,255,255,.3);padding:1.5rem;text-align:center;font-size:12px;margin-top:3rem}
  </style>
</head>
<body>

<nav>
  <a href="{{ route('boutique.index', $boutique->slug) }}" class="nav-logo">⬡ {{ $boutique->nom }}</a>
</nav>

<div class="main">
  <div class="check-circle"><i class="ti ti-check"></i></div>
  <div class="title">Commande confirmée !</div>
  <div class="subtitle">Merci pour votre commande. Nous allons la traiter dans les plus brefs délais.</div>

  <div class="card">
    <div class="row"><span class="row-key">Référence</span><span class="row-val">{{ $vente->reference }}</span></div>
    <div class="row"><span class="row-key">Date</span><span class="row-val">{{ $vente->created_at->format('d/m/Y à H:i') }}</span></div>
    <div class="row"><span class="row-key">Total</span><span class="row-val" style="color:var(--primary)">{{ number_format($vente->total_ttc, 0, ',', ' ') }} {{ $boutique->devise }}</span></div>
    <div class="row"><span class="row-key">Paiement</span><span class="row-val">{{ ucfirst(str_replace('_',' ',$vente->mode_paiement)) }}</span></div>
    <div class="row"><span class="row-key">Statut</span><span class="row-val" style="color:#F59E0B">En attente de traitement</span></div>
  </div>

  @if($vente->mode_paiement === 'orange_money')
  <div class="pay-info">
    <strong>🟠 Paiement Orange Money</strong>
    Envoyez <strong>{{ number_format($vente->total_ttc, 0, ',', ' ') }} {{ $boutique->devise }}</strong> au numéro Orange Money de la boutique et mentionnez la référence <strong>{{ $vente->reference }}</strong>.
  </div>
  @elseif($vente->mode_paiement === 'wero')
  <div class="pay-info">
    <strong>🟣 Paiement Wero</strong>
    Envoyez <strong>{{ number_format($vente->total_ttc, 0, ',', ' ') }} {{ $boutique->devise }}</strong> via Wero et mentionnez la référence <strong>{{ $vente->reference }}</strong>.
  </div>
  @elseif($vente->mode_paiement === 'sur_place')
  <div class="pay-info">
    <strong>💵 Paiement sur place</strong>
    Vous réglerez à la réception de votre commande. Gardez la référence <strong>{{ $vente->reference }}</strong>.
  </div>
  @endif

  <a href="{{ route('boutique.index', $boutique->slug) }}" class="btn-back">
    <i class="ti ti-arrow-left"></i> Continuer mes achats
  </a>
</div>

<footer>⬡ {{ $boutique->nom }} · Propulsé par <a href="/" style="color:var(--primary)">BoutiqueConnect</a></footer>
</body>
</html>