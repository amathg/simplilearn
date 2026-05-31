<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ $produit->nom }} — {{ $boutique->nom }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/tabler-icons/tabler-icons.min.css">
  <style>
    :root{--primary:{{ $boutique->couleur_primaire ?? '#F5B72E' }};--secondary:{{ $boutique->couleur_secondaire ?? '#1A1A1A' }};--radius:8px;--gray:#888;--light:#F5F5F0}
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'DM Sans',sans-serif;background:#F5F5F0;color:#1A1A1A}
    a{text-decoration:none;color:inherit}
    nav{background:var(--secondary);padding:.875rem 1.5rem;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50}
    .nav-logo{font-family:'Syne',sans-serif;font-weight:800;font-size:16px;color:var(--primary)}
    .nav-right{display:flex;align-items:center;gap:.75rem}
    .tb-btn{color:rgba(255,255,255,.6);font-size:11px;display:flex;flex-direction:column;align-items:center;gap:2px;padding:4px 8px;border-radius:4px;transition:.2s}
    .tb-btn:hover{color:#fff}
    .tb-btn i{font-size:18px}
    .tb-cart{display:inline-flex;align-items:center;gap:6px;color:#1A1A1A;font-weight:700;font-size:12px;padding:7px 14px;background:var(--primary);border-radius:var(--radius)}
    .tb-cart:hover{opacity:.85}
    .cart-count{background:#1A1A1A;color:var(--primary);font-size:10px;font-weight:900;padding:1px 6px;border-radius:10px}
    .main{max-width:1100px;margin:0 auto;padding:2rem 1.5rem}
    .breadcrumb{display:flex;align-items:center;gap:.5rem;font-size:12px;color:var(--gray);margin-bottom:1.5rem;flex-wrap:wrap}
    .breadcrumb a{color:var(--gray)}.breadcrumb a:hover{color:var(--primary)}
    .product-layout{display:grid;grid-template-columns:1fr 1fr;gap:2.5rem;align-items:start;margin-bottom:3rem}
    .product-img{background:#fff;border-radius:var(--radius);border:.5px solid #E5E5E0;aspect-ratio:1;display:flex;align-items:center;justify-content:center;overflow:hidden}
    .product-img img{width:100%;height:100%;object-fit:cover}
    .product-img i{font-size:80px;color:#DDD}
    .product-cat{font-size:11px;text-transform:uppercase;letter-spacing:.5px;color:var(--primary);font-weight:700;margin-bottom:.5rem}
    .product-name{font-family:'Syne',sans-serif;font-weight:800;font-size:1.75rem;line-height:1.2;margin-bottom:1rem}
    .product-price{font-family:'Syne',sans-serif;font-weight:800;font-size:2rem;color:var(--primary);margin-bottom:.25rem}
    .product-price-old{font-size:13px;color:#CCC;text-decoration:line-through;margin-bottom:1.25rem}
    .product-desc{font-size:14px;color:#555;line-height:1.75;margin-bottom:1.5rem}
    .stock-badge{display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:600;padding:5px 12px;border-radius:50px;margin-bottom:1.25rem}
    .stock-ok{background:#F0FDF4;color:#16A34A}
    .stock-low{background:#FFFBEB;color:#B45309}
    .stock-out{background:#FEF2F2;color:#DC2626}
    .qte-wrap{display:flex;align-items:center;gap:1rem;margin-bottom:1.25rem}
    .qte-label{font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#666}
    .qte-ctrl{display:flex;align-items:center;gap:.5rem}
    .qte-ctrl button{width:36px;height:36px;border:.5px solid #DDD;border-radius:6px;background:#fff;cursor:pointer;font-size:18px;transition:.2s;display:flex;align-items:center;justify-content:center}
    .qte-ctrl button:hover{background:var(--primary);border-color:var(--primary)}
    .qte-ctrl input{width:60px;height:36px;text-align:center;border:.5px solid #DDD;border-radius:6px;font-size:15px;font-weight:700;font-family:'DM Sans',sans-serif}
    .btn-add{background:var(--primary);color:#1A1A1A;border:none;border-radius:var(--radius);padding:14px 28px;font-size:14px;font-weight:700;cursor:pointer;font-family:'DM Sans',sans-serif;display:inline-flex;align-items:center;gap:8px;transition:.2s;width:100%;justify-content:center}
    .btn-add:hover{opacity:.85;transform:translateY(-1px)}
    .btn-add:disabled{background:#DDD;color:#999;cursor:not-allowed;transform:none}
    .similaires{margin-top:3rem}
    .similaires h2{font-family:'Syne',sans-serif;font-weight:800;font-size:1.1rem;margin-bottom:1.25rem}
    .sim-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:1rem}
    .sim-card{background:#fff;border-radius:var(--radius);border:.5px solid #E5E5E0;overflow:hidden;transition:transform .2s,box-shadow .2s}
    .sim-card:hover{transform:translateY(-3px);box-shadow:0 8px 24px rgba(0,0,0,.1)}
    .sim-img{height:120px;background:var(--light);display:flex;align-items:center;justify-content:center;overflow:hidden}
    .sim-img i{font-size:36px;color:#CCC}
    .sim-img img{width:100%;height:100%;object-fit:cover}
    .sim-info{padding:.75rem}
    .sim-name{font-size:12px;font-weight:700;margin-bottom:.375rem;line-height:1.3}
    .sim-price{font-family:'Syne',sans-serif;font-weight:800;font-size:13px;color:var(--primary)}
    footer{background:var(--secondary);color:rgba(255,255,255,.3);padding:1.5rem;text-align:center;font-size:12px;margin-top:3rem}
    @media(max-width:768px){.product-layout{grid-template-columns:1fr}.sim-grid{grid-template-columns:repeat(2,1fr)}}
  </style>
</head>
<body>

<nav>
  <a href="{{ route('boutique.index', $boutique->slug) }}" class="nav-logo">⬡ {{ $boutique->nom }}</a>
  <div class="nav-right">
    @if(session('client_id'))
    <a href="{{ route('boutique.mon-compte', $boutique->slug) }}" class="tb-btn">
      <i class="ti ti-user-circle"></i><span>{{ session('client.prenom', 'Compte') }}</span>
    </a>
    <a href="{{ route('boutique.deconnexion', $boutique->slug) }}" class="tb-btn" style="color:rgba(255,80,80,.7)">
      <i class="ti ti-logout"></i>
    </a>
    @else
    <a href="{{ route('boutique.connexion', $boutique->slug) }}" class="tb-btn">
      <i class="ti ti-user"></i><span>Connexion</span>
    </a>
    @endif
    <a href="{{ route('boutique.panier', $boutique->slug) }}" class="tb-cart">
      <i class="ti ti-shopping-cart" style="font-size:16px"></i> Panier
      @if($panier_count > 0)<span class="cart-count">{{ $panier_count }}</span>@endif
    </a>
  </div>
</nav>

<div class="main">
  <div class="breadcrumb">
    <a href="{{ route('boutique.index', $boutique->slug) }}">Accueil</a>
    <span>›</span>
    @if($produit->categorie)
    <a href="{{ route('boutique.index', $boutique->slug) }}?cat={{ $produit->categorie_id }}">{{ $produit->categorie->nom }}</a>
    <span>›</span>
    @endif
    <span style="color:#1A1A1A">{{ $produit->nom }}</span>
  </div>

  <div class="product-layout">
    <div class="product-img">
      @if($produit->image)
      <img src="/images/{{ $produit->image }}" alt="{{ $produit->nom }}">
      @else
      <i class="ti {{ $produit->icone ?? 'ti-package' }}"></i>
      @endif
    </div>
    <div>
      <div class="product-cat">{{ $produit->categorie?->nom ?? 'Produit' }}</div>
      <h1 class="product-name">{{ $produit->nom }}</h1>
      <div class="product-price">{{ number_format($produit->prix_final, 0, ',', ' ') }} {{ $boutique->devise }}</div>
      @if($produit->promo > 0)
      <div class="product-price-old">{{ number_format($produit->prix_vente, 0, ',', ' ') }} {{ $boutique->devise }} — Promo -{{ $produit->promo }}%</div>
      @endif
      @php $stock = $produit->stock?->quantite ?? 0; @endphp
      @if($stock === 0)
      <span class="stock-badge stock-out"><i class="ti ti-x"></i> Rupture de stock</span>
      @elseif($stock <= 5)
      <span class="stock-badge stock-low"><i class="ti ti-alert-circle"></i> Plus que {{ $stock }} en stock</span>
      @else
      <span class="stock-badge stock-ok"><i class="ti ti-check"></i> En stock ({{ $stock }} disponibles)</span>
      @endif
      <p class="product-desc">{{ $produit->description }}</p>
      @if($stock > 0)
      <form method="POST" action="{{ route('boutique.panier.ajouter', $boutique->slug) }}">
        @csrf
        <input type="hidden" name="produit_id" value="{{ $produit->id }}">
        <div class="qte-wrap">
          <span class="qte-label">Quantité</span>
          <div class="qte-ctrl">
            <button type="button" onclick="let i=this.nextElementSibling;i.value=Math.max(1,+i.value-1)">−</button>
            <input type="number" name="quantite" value="1" min="1" max="{{ $stock }}">
            <button type="button" onclick="let i=this.previousElementSibling;i.value=Math.min({{ $stock }},+i.value+1)">+</button>
          </div>
        </div>
        <button type="submit" class="btn-add">
          <i class="ti ti-shopping-cart-plus" style="font-size:18px"></i> Ajouter au panier
        </button>
      </form>
      @else
      <button class="btn-add" disabled><i class="ti ti-shopping-cart-off"></i> Rupture de stock</button>
      @endif
    </div>
  </div>

  @if($similaires->count() > 0)
  <div class="similaires">
    <h2>Produits similaires</h2>
    <div class="sim-grid">
      @foreach($similaires as $s)
      <a href="{{ route('boutique.produit', [$boutique->slug, $s->id]) }}" class="sim-card">
        <div class="sim-img">
          @if($s->image)
          <img src="/images/{{ $s->image }}" alt="{{ $s->nom }}">
          @else
          <i class="ti {{ $s->icone ?? 'ti-package' }}"></i>
          @endif
        </div>
        <div class="sim-info">
          <div class="sim-name">{{ Str::limit($s->nom, 40) }}</div>
          <div class="sim-price">{{ number_format($s->prix_final, 0, ',', ' ') }} {{ $boutique->devise }}</div>
        </div>
      </a>
      @endforeach
    </div>
  </div>
  @endif
</div>

<footer>⬡ {{ $boutique->nom }} · Propulsé par <a href="/" style="color:var(--primary)">BoutiqueConnect</a></footer>
</body>
</html>