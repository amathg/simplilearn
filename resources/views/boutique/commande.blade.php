<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Passer commande — {{ $boutique->nom }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/tabler-icons/tabler-icons.min.css">
  <style>
    :root{--primary:{{ $boutique->couleur_primaire ?? '#F5B72E' }};--secondary:{{ $boutique->couleur_secondaire ?? '#1A1A1A' }};--radius:8px}
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'DM Sans',sans-serif;background:#F5F5F0;color:#1A1A1A}
    a{text-decoration:none;color:inherit}
    nav{background:var(--secondary);padding:.875rem 1.5rem;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50}
    .nav-logo{font-family:'Syne',sans-serif;font-weight:800;font-size:16px;color:var(--primary)}
    .main{max-width:900px;margin:0 auto;padding:2rem 1.5rem}
    .page-title{font-family:'Syne',sans-serif;font-weight:800;font-size:1.5rem;margin-bottom:1.5rem}
    .layout{display:grid;grid-template-columns:1fr 300px;gap:1.5rem;align-items:start}
    .card{background:#fff;border-radius:var(--radius);border:.5px solid #E5E5E0;padding:1.5rem}
    .section-title{font-family:'Syne',sans-serif;font-weight:700;font-size:14px;margin-bottom:1rem;padding-bottom:.5rem;border-bottom:.5px solid #F0F0EB}
    .fg{display:flex;flex-direction:column;gap:5px;margin-bottom:.875rem}
    .fg label{font-size:11px;text-transform:uppercase;letter-spacing:.5px;color:#666;font-weight:700}
    .fg input,.fg select,.fg textarea{border:.5px solid #DDD;border-radius:var(--radius);padding:9px 11px;font-size:13px;font-family:'DM Sans',sans-serif;color:#1A1A1A;outline:none;transition:border-color .2s;width:100%}
    .fg input:focus,.fg select:focus{border-color:var(--primary)}
    .row2{display:grid;grid-template-columns:1fr 1fr;gap:.875rem}
    .pay-options{display:grid;grid-template-columns:1fr 1fr;gap:.5rem;margin-bottom:1rem}
    .pay-opt{border:.5px solid #DDD;border-radius:6px;padding:.75rem;cursor:pointer;transition:.2s;display:flex;align-items:center;gap:.5rem;font-size:12px;font-weight:600}
    .pay-opt:has(input:checked){border-color:var(--primary);background:#FFFBEB}
    .pay-opt input{accent-color:var(--primary)}
    .retrait-options{display:grid;grid-template-columns:1fr 1fr;gap:.5rem;margin-bottom:1rem}
    .retrait-opt{border:.5px solid #DDD;border-radius:6px;padding:.875rem;cursor:pointer;transition:.2s;display:flex;align-items:center;gap:.5rem;font-size:12px;font-weight:600}
    .retrait-opt:has(input:checked){border-color:var(--primary);background:#FFFBEB}
    .retrait-opt input{accent-color:var(--primary)}
    .magasin-card{border:.5px solid #DDD;border-radius:6px;padding:.75rem;cursor:pointer;transition:.2s;display:flex;align-items:flex-start;gap:.75rem;margin-bottom:.5rem}
    .magasin-card:has(input:checked){border-color:var(--primary);background:#FFFBEB}
    .magasin-card input{accent-color:var(--primary);margin-top:2px;flex-shrink:0}
    .magasin-card .magasin-info{flex:1}
    .magasin-card .magasin-nom{font-size:13px;font-weight:700}
    .magasin-card .magasin-details{font-size:11px;color:#888;margin-top:2px}
    .recap-row{display:flex;justify-content:space-between;font-size:13px;margin-bottom:.75rem}
    .recap-total{display:flex;justify-content:space-between;font-family:'Syne',sans-serif;font-weight:800;font-size:1.1rem;padding-top:.75rem;border-top:.5px solid #F0F0EB}
    .item-row{display:flex;align-items:center;gap:.75rem;padding:.5rem 0;border-bottom:.5px solid #F7F7F5;font-size:12px}
    .item-row:last-child{border-bottom:none}
    .item-img-sm{width:36px;height:36px;border-radius:4px;background:#F5F5F0;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0}
    .item-img-sm img{width:100%;height:100%;object-fit:cover}
    .item-img-sm i{font-size:14px;color:#CCC}
    .btn-cmd{display:block;background:var(--primary);color:#1A1A1A;border:none;border-radius:var(--radius);padding:14px;font-size:14px;font-weight:700;cursor:pointer;font-family:'DM Sans',sans-serif;text-align:center;margin-top:1rem;transition:.2s;width:100%}
    .btn-cmd:hover{opacity:.85}
    .badge-principal{background:var(--primary);color:#1A1A1A;font-size:9px;font-weight:800;padding:2px 6px;border-radius:4px;text-transform:uppercase;letter-spacing:.5px}
    footer{background:var(--secondary);color:rgba(255,255,255,.3);padding:1.5rem;text-align:center;font-size:12px;margin-top:3rem}
    @media(max-width:768px){.layout{grid-template-columns:1fr}.row2{grid-template-columns:1fr}.pay-options{grid-template-columns:1fr 1fr}.retrait-options{grid-template-columns:1fr 1fr}}
  </style>
</head>
<body>

<nav>
  <a href="{{ route('boutique.index', $boutique->slug) }}" class="nav-logo">⬡ {{ $boutique->nom }}</a>
</nav>

<div class="main">
  <div class="page-title">Finaliser la commande</div>

  @if($errors->any())
  <div style="background:#FEF2F2;border:.5px solid #FCA5A5;border-radius:var(--radius);padding:1rem;margin-bottom:1rem;font-size:13px;color:#DC2626">
    <ul style="list-style:none">
      @foreach($errors->all() as $error)
      <li><i class="ti ti-alert-circle"></i> {{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form method="POST" action="{{ route('boutique.commande.store', $boutique->slug) }}">
    @csrf
    <div class="layout">
      <div>

        <!-- Coordonnées -->
        <div class="card" style="margin-bottom:1rem">
          <div class="section-title"><i class="ti ti-user" style="color:var(--primary)"></i> Vos coordonnées</div>
          <div class="row2">
            <div class="fg"><label>Prénom *</label><input type="text" name="prenom" value="{{ old('prenom', session('client.prenom', '')) }}" required></div>
            <div class="fg"><label>Nom *</label><input type="text" name="nom" value="{{ old('nom', session('client.nom', '')) }}" required></div>
          </div>
          <div class="fg"><label>Email *</label><input type="email" name="email" value="{{ old('email', session('client.email', '')) }}" required></div>
          <div class="fg"><label>Téléphone</label><input type="tel" name="telephone" value="{{ old('telephone', session('client.telephone', '')) }}"></div>
          <div class="fg"><label>Notes / Instructions</label><textarea name="notes" rows="2" placeholder="Instructions spéciales...">{{ old('notes') }}</textarea></div>
        </div>

        <!-- Mode de retrait -->
        <div class="card" style="margin-bottom:1rem">
          <div class="section-title"><i class="ti ti-truck" style="color:var(--primary)"></i> Mode de retrait</div>
          <div class="retrait-options">
            <label class="retrait-opt">
              <input type="radio" name="mode_retrait" value="livraison" {{ old('mode_retrait', 'livraison') === 'livraison' ? 'checked' : '' }}>
              <span>🚚 Livraison à domicile</span>
            </label>
            <label class="retrait-opt">
              <input type="radio" name="mode_retrait" value="retrait" {{ old('mode_retrait') === 'retrait' ? 'checked' : '' }}>
              <span>🏪 Retrait en magasin</span>
            </label>
          </div>

          <!-- Adresse livraison -->
          <div id="section-livraison">
            <div class="fg"><label>Adresse de livraison</label><input type="text" name="adresse" value="{{ old('adresse', session('client.adresse', '')) }}" placeholder="Rue, quartier, ville..."></div>
          </div>

          <!-- Choix du magasin -->
          <div id="section-retrait" style="display:none">
            @if($magasins->isEmpty())
            <div style="text-align:center;padding:1rem;color:#888;font-size:13px">
              <i class="ti ti-building-store" style="font-size:1.5rem;display:block;margin-bottom:.5rem"></i>
              Aucun magasin disponible pour le retrait.
            </div>
            @else
            <div style="font-size:11px;text-transform:uppercase;letter-spacing:.5px;color:#666;font-weight:700;margin-bottom:.75rem">Choisissez votre magasin</div>
            @foreach($magasins as $magasin)
            <label class="magasin-card">
              <input type="radio" name="magasin_id" value="{{ $magasin->id }}" {{ old('magasin_id') == $magasin->id || ($magasin->principal && !old('magasin_id')) ? 'checked' : '' }}>
              <div class="magasin-info">
                <div class="magasin-nom">
                  {{ $magasin->nom }}
                  @if($magasin->principal)
                  <span class="badge-principal">Principal</span>
                  @endif
                </div>
                <div class="magasin-details">
                  @if($magasin->adresse) <i class="ti ti-map-pin"></i> {{ $magasin->adresse }}@endif
                  @if($magasin->ville) — {{ $magasin->ville }}@endif
                  @if($magasin->telephone)<br><i class="ti ti-phone"></i> {{ $magasin->telephone }}@endif
                </div>
              </div>
            </label>
            @endforeach
            @endif
          </div>
        </div>

        <!-- Paiement -->
        <div class="card">
          <div class="section-title"><i class="ti ti-credit-card" style="color:var(--primary)"></i> Mode de paiement</div>
          <div class="pay-options">
            <label class="pay-opt">
              <input type="radio" name="mode_paiement" value="sur_place" checked>
              <span>💵 Sur place</span>
            </label>
            <label class="pay-opt">
              <input type="radio" name="mode_paiement" value="orange_money">
              <span>🟠 Orange Money</span>
            </label>
            <label class="pay-opt">
              <input type="radio" name="mode_paiement" value="wero">
              <span>🟣 Wero</span>
            </label>
            <label class="pay-opt">
              <input type="radio" name="mode_paiement" value="carte">
              <span>💳 Carte</span>
            </label>
          </div>
          <div id="om-info" style="display:none">
            <div class="fg"><label>Numéro Orange Money</label><input type="tel" name="om_numero" placeholder="ex: 77 123 45 67"></div>
          </div>
          <div id="wero-info" style="display:none">
            <div class="fg"><label>Numéro de téléphone Wero</label><input type="tel" name="wero_tel" placeholder="ex: +33 6 12 34 56 78"></div>
          </div>
        </div>

      </div>

      <!-- Récapitulatif -->
      <div>
        <div class="card">
          <div class="section-title"><i class="ti ti-receipt" style="color:var(--primary)"></i> Votre commande</div>
          @foreach($panier as $pid => $item)
          <div class="item-row">
            <div class="item-img-sm">
              @if(!empty($item['image']))
              <img src="/images/{{ $item['image'] }}" alt="{{ $item['nom'] }}">
              @else
              <i class="ti ti-package"></i>
              @endif
            </div>
            <div style="flex:1">
              <div style="font-weight:600">{{ Str::limit($item['nom'], 30) }}</div>
              <div style="color:#888">× {{ $item['quantite'] }}</div>
            </div>
            <div style="font-weight:700;color:var(--primary)">{{ number_format($item['prix'] * $item['quantite'], 0, ',', ' ') }}</div>
          </div>
          @endforeach
          <div style="margin-top:.75rem">
            <div class="recap-row"><span>Sous-total</span><span>{{ number_format($total, 0, ',', ' ') }}</span></div>
            <div class="recap-row"><span>Livraison</span><span style="color:#22C55E">Gratuite</span></div>
            <div class="recap-total">
              <span>Total</span>
              <span style="color:var(--primary)">{{ number_format($total, 0, ',', ' ') }} {{ $boutique->devise }}</span>
            </div>
          </div>
          <button type="submit" class="btn-cmd">
            <i class="ti ti-check"></i> Confirmer la commande
          </button>
          <a href="{{ route('boutique.panier', $boutique->slug) }}" style="display:block;text-align:center;font-size:12px;color:#888;margin-top:.75rem">
            ← Modifier mon panier
          </a>
        </div>
      </div>
    </div>
  </form>
</div>

<footer>⬡ {{ $boutique->nom }} · Propulsé par <a href="/" style="color:var(--primary)">BoutiqueConnect</a></footer>

<script>
// Mode paiement
document.querySelectorAll('input[name="mode_paiement"]').forEach(r => {
  r.addEventListener('change', () => {
    document.getElementById('om-info').style.display = r.value === 'orange_money' ? 'block' : 'none';
    document.getElementById('wero-info').style.display = r.value === 'wero' ? 'block' : 'none';
  });
});

// Mode retrait
document.querySelectorAll('input[name="mode_retrait"]').forEach(r => {
  r.addEventListener('change', () => {
    const isRetrait = r.value === 'retrait';
    document.getElementById('section-livraison').style.display = isRetrait ? 'none' : 'block';
    document.getElementById('section-retrait').style.display = isRetrait ? 'block' : 'none';
  });
});

// Initialisation au chargement
const retraitChecked = document.querySelector('input[name="mode_retrait"]:checked');
if (retraitChecked && retraitChecked.value === 'retrait') {
  document.getElementById('section-livraison').style.display = 'none';
  document.getElementById('section-retrait').style.display = 'block';
}
</script>
</body>
</html>