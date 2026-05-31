<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Mon panier — {{ $boutique->nom }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/tabler-icons/tabler-icons.min.css">
  <style>
    :root{--primary:{{ $boutique->couleur_primaire ?? '#F5B72E' }};--secondary:{{ $boutique->couleur_secondaire ?? '#1A1A1A' }};--radius:8px}
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'DM Sans',sans-serif;background:#F5F5F0;color:#1A1A1A}
    a{text-decoration:none;color:inherit}
    nav{background:var(--secondary);padding:.875rem 1.5rem;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50}
    .nav-logo{font-family:'Syne',sans-serif;font-weight:800;font-size:16px;color:var(--primary)}
    .nav-right{display:flex;align-items:center;gap:.75rem}
    .tb-btn{color:rgba(255,255,255,.6);font-size:11px;display:flex;flex-direction:column;align-items:center;gap:2px;padding:4px 8px;border-radius:4px}
    .tb-btn i{font-size:18px}
    .tb-cart{display:inline-flex;align-items:center;gap:6px;color:#1A1A1A;font-weight:700;font-size:12px;padding:7px 14px;background:var(--primary);border-radius:var(--radius)}
    .main{max-width:900px;margin:0 auto;padding:2rem 1.5rem}
    .page-title{font-family:'Syne',sans-serif;font-weight:800;font-size:1.5rem;margin-bottom:1.5rem}
    .layout{display:grid;grid-template-columns:1fr 300px;gap:1.5rem;align-items:start}
    .card{background:#fff;border-radius:var(--radius);border:.5px solid #E5E5E0;overflow:hidden}
    .panier-item{display:flex;align-items:center;gap:1rem;padding:1rem 1.25rem;border-bottom:.5px solid #F5F5F0}
    .panier-item:last-child{border-bottom:none}
    .item-img{width:60px;height:60px;border-radius:6px;background:#F5F5F0;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0}
    .item-img img{width:100%;height:100%;object-fit:cover}
    .item-img i{font-size:24px;color:#CCC}
    .item-info{flex:1}
    .item-name{font-size:13px;font-weight:700;margin-bottom:2px}
    .item-cat{font-size:11px;color:#888}
    .item-ctrl{display:flex;align-items:center;gap:.5rem}
    .qte-btn{width:28px;height:28px;border:.5px solid #DDD;border-radius:4px;background:#fff;cursor:pointer;font-size:14px;display:flex;align-items:center;justify-content:center;transition:.2s}
    .qte-btn:hover{background:var(--primary);border-color:var(--primary)}
    .qte-val{width:40px;text-align:center;font-size:13px;font-weight:700;border:.5px solid #DDD;border-radius:4px;padding:3px;font-family:'DM Sans',sans-serif}
    .item-price{font-family:'Syne',sans-serif;font-weight:800;font-size:14px;color:var(--primary);min-width:80px;text-align:right}
    .btn-retirer{background:none;border:none;color:#CCC;cursor:pointer;font-size:18px;padding:4px;transition:.2s}
    .btn-retirer:hover{color:#EF4444}
    .recap{padding:1.25rem}
    .recap-row{display:flex;justify-content:space-between;font-size:13px;margin-bottom:.75rem}
    .recap-total{display:flex;justify-content:space-between;font-family:'Syne',sans-serif;font-weight:800;font-size:1.1rem;padding-top:.75rem;border-top:.5px solid #F0F0EB}
    .btn-cmd{display:block;background:var(--primary);color:#1A1A1A;border:none;border-radius:var(--radius);padding:14px;font-size:14px;font-weight:700;cursor:pointer;font-family:'DM Sans',sans-serif;text-align:center;margin-top:1rem;transition:.2s;width:100%}
    .btn-cmd:hover{opacity:.85}
    .btn-back{display:inline-flex;align-items:center;gap:6px;font-size:13px;color:#888;margin-bottom:1.5rem}
    .btn-back:hover{color:var(--primary)}
    .empty{text-align:center;padding:3rem;color:#AAA}
    .empty i{font-size:3rem;display:block;margin-bottom:1rem}
    footer{background:var(--secondary);color:rgba(255,255,255,.3);padding:1.5rem;text-align:center;font-size:12px;margin-top:3rem}
    @media(max-width:768px){.layout{grid-template-columns:1fr}}
  </style>
</head>
<body>

<nav>
  <a href="{{ route('boutique.index', $boutique->slug) }}" class="nav-logo">⬡ {{ $boutique->nom }}</a>
  <div class="nav-right">
    @if(session('client_id'))
    <a href="{{ route('boutique.mon-compte', $boutique->slug) }}" class="tb-btn"><i class="ti ti-user-circle"></i></a>
    @else
    <a href="{{ route('boutique.connexion', $boutique->slug) }}" class="tb-btn"><i class="ti ti-user"></i></a>
    @endif
    <a href="{{ route('boutique.panier', $boutique->slug) }}" class="tb-cart">
      <i class="ti ti-shopping-cart" style="font-size:16px"></i> Panier
      @if(count($panier) > 0)<span style="background:#1A1A1A;color:var(--primary);font-size:10px;font-weight:900;padding:1px 6px;border-radius:10px">{{ array_sum(array_column($panier,'quantite')) }}</span>@endif
    </a>
  </div>
</nav>

<div class="main">
  <a href="{{ route('boutique.index', $boutique->slug) }}" class="btn-back">
    <i class="ti ti-arrow-left"></i> Continuer mes achats
  </a>
  <div class="page-title">Mon panier</div>

  @if(count($panier) > 0)
  <div class="layout">
    <div class="card">
      @foreach($panier as $pid => $item)
      <div class="panier-item">
        <div class="item-img">
          @if(!empty($item['image']))
          <img src="/images/{{ $item['image'] }}" alt="{{ $item['nom'] }}">
          @else
          <i class="ti ti-package"></i>
          @endif
        </div>
        <div class="item-info">
          <div class="item-name">{{ $item['nom'] }}</div>
          <div class="item-cat">{{ number_format($item['prix'], 0, ',', ' ') }} {{ $boutique->devise }} / unité</div>
        </div>
        <div class="item-ctrl">
          <a href="{{ route('boutique.panier.maj', $boutique->slug) }}?produit_id={{ $pid }}&action=moins" class="qte-btn">−</a>
          <span class="qte-val">{{ $item['quantite'] }}</span>
          <a href="{{ route('boutique.panier.maj', $boutique->slug) }}?produit_id={{ $pid }}&action=plus" class="qte-btn">+</a>
        </div>
        <div class="item-price">{{ number_format($item['prix'] * $item['quantite'], 0, ',', ' ') }}</div>
        <a href="{{ route('boutique.panier.retirer', [$boutique->slug, $pid]) }}" class="btn-retirer">
          <i class="ti ti-x"></i>
        </a>
      </div>
      @endforeach
    </div>

    <div class="card" style="padding:0">
      <div style="padding:1.25rem;border-bottom:.5px solid #F0F0EB">
        <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:13px">Récapitulatif</div>
      </div>
      <div class="recap">
        <div class="recap-row"><span>Sous-total</span><span>{{ number_format($total, 0, ',', ' ') }} {{ $boutique->devise }}</span></div>
        <div class="recap-row"><span>Livraison</span><span style="color:#22C55E">Gratuite</span></div>
        <div class="recap-total">
          <span>Total</span>
          <span style="color:var(--primary)">{{ number_format($total, 0, ',', ' ') }} {{ $boutique->devise }}</span>
        </div>
        <a href="{{ route('boutique.commande', $boutique->slug) }}" class="btn-cmd">
          <i class="ti ti-credit-card"></i> Passer commande
        </a>
      </div>
    </div>
  </div>
  @else
  <div class="card">
    <div class="empty">
      <i class="ti ti-shopping-cart-off"></i>
      <p style="font-size:14px;font-weight:600;margin-bottom:.5rem">Votre panier est vide</p>
      <p style="font-size:13px">Découvrez nos produits et ajoutez-les à votre panier.</p>
      <a href="{{ route('boutique.index', $boutique->slug) }}" style="display:inline-block;margin-top:1.5rem;background:var(--primary);color:#1A1A1A;padding:10px 24px;border-radius:var(--radius);font-weight:700;font-size:13px">
        Voir les produits
      </a>
    </div>
  </div>
  @endif
</div>

<footer>⬡ {{ $boutique->nom }} · Propulsé par <a href="/" style="color:var(--primary)">BoutiqueConnect</a></footer>
</body>
</html>