<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ $boutique->nom }} — Boutique en ligne</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/tabler-icons/tabler-icons.min.css">
  <style>
    :root{--primary:{{ $boutique->couleur_primaire ?? '#F5B72E' }};--secondary:{{ $boutique->couleur_secondaire ?? '#1A1A1A' }};--radius:8px;--gray:#888;--light:#F5F5F0}
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'DM Sans',sans-serif;background:#F5F5F0;color:#1A1A1A}
    a{text-decoration:none;color:inherit}
    /* NAV */
    nav{background:var(--secondary);padding:.875rem 1.5rem;display:flex;align-items:center;justify-content:space-between;gap:1rem;position:sticky;top:0;z-index:50}
    .nav-logo{font-family:'Syne',sans-serif;font-weight:800;font-size:16px;color:var(--primary)}
    .nav-cats{display:flex;gap:.25rem;overflow-x:auto;scrollbar-width:none;flex:1;justify-content:center}
    .nav-cats::-webkit-scrollbar{display:none}
    .nav-cat{font-size:11px;color:rgba(255,255,255,.5);padding:5px 10px;border-radius:4px;white-space:nowrap;transition:.2s;cursor:pointer;border:none;background:none;font-family:'DM Sans',sans-serif}
    .nav-cat:hover,.nav-cat.active{color:#fff;background:rgba(255,255,255,.1)}
    .nav-right{display:flex;align-items:center;gap:.5rem}
    .tb-btn{color:rgba(255,255,255,.6);font-size:11px;display:flex;flex-direction:column;align-items:center;gap:2px;padding:4px 8px;border-radius:4px;transition:.2s}
    .tb-btn:hover{color:#fff}
    .tb-btn i{font-size:18px}
    .tb-cart{display:inline-flex;align-items:center;gap:6px;color:#1A1A1A;font-weight:700;font-size:12px;padding:7px 14px;background:var(--primary);border-radius:var(--radius)}
    .tb-cart:hover{opacity:.85}
    .cart-count{background:#1A1A1A;color:var(--primary);font-size:10px;font-weight:900;padding:1px 6px;border-radius:10px}
    /* FILTRES */
    .filters{background:#fff;border-bottom:.5px solid #E5E5E0;padding:.875rem 1.5rem;display:flex;align-items:center;gap:1rem;flex-wrap:wrap}
    .filter-tabs{display:flex;gap:.375rem;flex-wrap:wrap;flex:1}
    .filter-tab{font-size:12px;padding:5px 12px;border-radius:50px;border:.5px solid #E5E5E0;background:#fff;cursor:pointer;transition:.2s;font-family:'DM Sans',sans-serif;color:#666}
    .filter-tab:hover{border-color:var(--primary);color:var(--primary)}
    .filter-tab.active{background:var(--primary);border-color:var(--primary);color:#1A1A1A;font-weight:700}
    .filter-sort{display:flex;align-items:center;gap:.5rem;font-size:12px;color:#888}
    .filter-sort select{border:.5px solid #E5E5E0;border-radius:4px;padding:5px 10px;font-size:12px;font-family:'DM Sans',sans-serif;color:#1A1A1A;outline:none}
    /* GRILLE */
    .main{max-width:1200px;margin:0 auto;padding:1.5rem}
    .result-info{font-size:12px;color:#888;margin-bottom:1rem}
    .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1rem}
    .card{background:#fff;border-radius:var(--radius);border:.5px solid #E5E5E0;overflow:hidden;transition:transform .2s,box-shadow .2s;position:relative}
    .card:hover{transform:translateY(-3px);box-shadow:0 8px 24px rgba(0,0,0,.1)}
    .card-img{height:180px;background:var(--light);display:flex;align-items:center;justify-content:center;overflow:hidden;position:relative}
    .card-img img{width:100%;height:100%;object-fit:cover}
    .card-img i{font-size:48px;color:#CCC}
    .badge-new{position:absolute;top:8px;left:8px;background:var(--primary);color:#1A1A1A;font-size:9px;font-weight:700;padding:2px 8px;border-radius:3px}
    .badge-promo{position:absolute;top:8px;right:8px;background:#EF4444;color:#fff;font-size:9px;font-weight:700;padding:2px 8px;border-radius:3px}
    .card-body{padding:.875rem}
    .card-cat{font-size:10px;text-transform:uppercase;letter-spacing:.5px;color:var(--primary);font-weight:700;margin-bottom:.3rem}
    .card-name{font-size:13px;font-weight:700;margin-bottom:.375rem;line-height:1.4;color:#1A1A1A}
    .card-desc{font-size:11px;color:#888;line-height:1.5;margin-bottom:.75rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
    .card-footer{display:flex;align-items:center;justify-content:space-between;gap:.5rem}
    .card-price{font-family:'Syne',sans-serif;font-weight:800;font-size:15px;color:var(--primary)}
    .btn-add{background:var(--primary);color:#1A1A1A;border:none;border-radius:5px;padding:6px 12px;font-size:11px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:4px;font-family:'DM Sans',sans-serif;transition:.2s}
    .btn-add:hover{opacity:.85}
    .btn-add:disabled{background:#DDD;color:#999;cursor:not-allowed}
    .empty{text-align:center;padding:4rem;color:#AAA}
    .empty i{font-size:3rem;display:block;margin-bottom:1rem}
    /* FOOTER */
    footer{background:var(--secondary);color:rgba(255,255,255,.4);padding:2rem 1.5rem;margin-top:3rem}
    .footer-grid{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:2rem}
    .footer-brand{color:#fff;font-family:'Syne',sans-serif;font-weight:800;font-size:15px;margin-bottom:.5rem}
    .footer-info{font-size:12px;line-height:1.8}
    .footer-title{color:rgba(255,255,255,.6);font-size:10px;text-transform:uppercase;letter-spacing:1px;font-weight:700;margin-bottom:.75rem}
    .footer-links{display:flex;flex-direction:column;gap:.375rem}
    .footer-links a{font-size:12px;color:rgba(255,255,255,.4);transition:.2s}
    .footer-links a:hover{color:var(--primary)}
    footer hr{border:.5px solid rgba(255,255,255,.08);margin:1.5rem auto;max-width:1200px}
    .footer-bottom{max-width:1200px;margin:0 auto;font-size:11px;text-align:center}
    @media(max-width:768px){.grid{grid-template-columns:repeat(2,1fr)}.nav-cats{display:none}}
  </style>
</head>
<body>

<nav>
  <a href="{{ route('boutique.index', $boutique->slug) }}" class="nav-logo">⬡ {{ $boutique->nom }}</a>
  <div class="nav-cats">
    <a href="{{ route('boutique.index', $boutique->slug) }}" class="nav-cat {{ !request('cat') ? 'active' : '' }}">Accueil</a>
    @foreach($categories as $cat)
    <a href="{{ route('boutique.index', $boutique->slug) }}?cat={{ $cat->id }}" class="nav-cat {{ request('cat') == $cat->id ? 'active' : '' }}">{{ $cat->nom }}</a>
    @endforeach
  </div>
  <div class="nav-right">
    @if(session('client_id'))
    <a href="{{ route('boutique.mon-compte', $boutique->slug) }}" class="tb-btn">
      <i class="ti ti-user-circle"></i>
      <span>{{ session('client.prenom', 'Compte') }}</span>
    </a>
    <a href="{{ route('boutique.deconnexion', $boutique->slug) }}" class="tb-btn" style="color:rgba(255,80,80,.7)">
      <i class="ti ti-logout"></i>
    </a>
    @else
    <a href="{{ route('boutique.connexion', $boutique->slug) }}" class="tb-btn">
      <i class="ti ti-user"></i>
      <span>Connexion</span>
    </a>
    @endif
    <a href="{{ route('boutique.panier', $boutique->slug) }}" class="tb-cart">
      <i class="ti ti-shopping-cart" style="font-size:16px"></i>
      Panier
      @if($panier_count > 0)
      <span class="cart-count">{{ $panier_count }}</span>
      @endif
    </a>
  </div>
</nav>

<!-- FILTRES -->
<div class="filters">
  <div class="filter-tabs">
    <a href="{{ route('boutique.index', $boutique->slug) }}" class="filter-tab {{ !request('cat') ? 'active' : '' }}">
      <i class="ti ti-apps"></i> Tous
    </a>
    @foreach($categories as $cat)
    <a href="{{ route('boutique.index', $boutique->slug) }}?cat={{ $cat->id }}" class="filter-tab {{ request('cat') == $cat->id ? 'active' : '' }}">
      {{ $cat->nom }}
    </a>
    @endforeach
  </div>
  <div class="filter-sort">
    <span>Trier :</span>
    <select onchange="window.location=this.value">
      <option value="{{ route('boutique.index', $boutique->slug) }}{{ request('cat') ? '?cat='.request('cat').'&sort=recent' : '?sort=recent' }}" {{ request('sort','recent') === 'recent' ? 'selected' : '' }}>Plus récents</option>
      <option value="{{ route('boutique.index', $boutique->slug) }}{{ request('cat') ? '?cat='.request('cat').'&sort=prix_asc' : '?sort=prix_asc' }}" {{ request('sort') === 'prix_asc' ? 'selected' : '' }}>Prix croissant</option>
      <option value="{{ route('boutique.index', $boutique->slug) }}{{ request('cat') ? '?cat='.request('cat').'&sort=prix_desc' : '?sort=prix_desc' }}" {{ request('sort') === 'prix_desc' ? 'selected' : '' }}>Prix décroissant</option>
    </select>
  </div>
</div>

<div class="main">
  <div class="result-info">{{ $produits->total() }} produit{{ $produits->total() > 1 ? 's' : '' }}</div>

  @if($produits->count() > 0)
  <div class="grid">
    @foreach($produits as $p)
    <div class="card">
      <a href="{{ route('boutique.produit', [$boutique->slug, $p->id]) }}">
        <div class="card-img">
          @if($p->image)
          <img src="/images/{{ $p->image }}" alt="{{ $p->nom }}" loading="lazy">
          @else
          <i class="ti {{ $p->icone ?? 'ti-package' }}"></i>
          @endif
          @if($p->nouveau)<span class="badge-new">Nouveau</span>@endif
          @if($p->promo > 0)<span class="badge-promo">-{{ $p->promo }}%</span>@endif
        </div>
      </a>
      <div class="card-body">
        <div class="card-cat">{{ $p->categorie?->nom }}</div>
        <a href="{{ route('boutique.produit', [$boutique->slug, $p->id]) }}">
          <div class="card-name">{{ $p->nom }}</div>
        </a>
        <div class="card-desc">{{ $p->description }}</div>
        <div class="card-footer">
          <div>
            <div class="card-price">{{ number_format($p->prix_final, 0, ',', ' ') }} {{ $boutique->devise }}</div>
            @if($p->promo > 0)
            <div style="font-size:10px;color:#CCC;text-decoration:line-through">{{ number_format($p->prix_vente, 0, ',', ' ') }}</div>
            @endif
          </div>
          @php $stock = $p->stock?->quantite ?? 0; @endphp
          <form method="POST" action="{{ route('boutique.panier.ajouter', $boutique->slug) }}">
            @csrf
            <input type="hidden" name="produit_id" value="{{ $p->id }}">
            <input type="hidden" name="quantite" value="1">
            <button type="submit" class="btn-add" {{ $stock <= 0 ? 'disabled' : '' }}>
              <i class="ti ti-plus"></i> {{ $stock <= 0 ? 'Épuisé' : 'Ajouter' }}
            </button>
          </form>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div style="margin-top:1.5rem">{{ $produits->links() }}</div>
  @else
  <div class="empty">
    <i class="ti ti-package-off"></i>
    <p>Aucun produit trouvé.</p>
  </div>
  @endif
</div>

<footer>
  <div class="footer-grid">
    <div>
      <div class="footer-brand">⬡ {{ $boutique->nom }}</div>
      <div class="footer-info">
        @if($boutique->telephone)<div><i class="ti ti-phone" style="font-size:12px"></i> {{ $boutique->telephone }}</div>@endif
        @if($boutique->ville)<div><i class="ti ti-map-pin" style="font-size:12px"></i> {{ $boutique->ville }}</div>@endif
        @if($boutique->description)<div style="margin-top:.5rem">{{ $boutique->description }}</div>@endif
      </div>
    </div>
    <div>
      <div class="footer-title">Catégories</div>
      <div class="footer-links">
        @foreach($categories->take(6) as $cat)
        <a href="{{ route('boutique.index', $boutique->slug) }}?cat={{ $cat->id }}">{{ $cat->nom }}</a>
        @endforeach
      </div>
    </div>
    <div>
      <div class="footer-title">Mon compte</div>
      <div class="footer-links">
        <a href="{{ route('boutique.mon-compte', $boutique->slug) }}">Mon espace</a>
        @if(session('client_id'))
        <a href="{{ route('boutique.deconnexion', $boutique->slug) }}" style="color:rgba(255,100,100,.7)">Se déconnecter</a>
        @else
        <a href="{{ route('boutique.connexion', $boutique->slug) }}">Se connecter</a>
        @endif
        <a href="{{ route('boutique.panier', $boutique->slug) }}">Mon panier</a>
      </div>
    </div>
    <div>
      <div class="footer-title">Aide</div>
      <div class="footer-links">
        <a href="#">Comment commander ?</a>
        <a href="#">Modes de paiement</a>
        <a href="#">Livraison</a>
        <a href="#">Nous contacter</a>
      </div>
    </div>
  </div>
  <hr>
  <div class="footer-bottom">© {{ date('Y') }} {{ $boutique->nom }} · Propulsé par <a href="/" style="color:var(--primary)">BoutiqueConnect</a></div>
</footer>

</body>
</html>