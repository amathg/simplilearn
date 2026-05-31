<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Mon compte — {{ $boutique->nom }}</title>
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
    .main{max-width:900px;margin:0 auto;padding:2rem 1.5rem}
    .page-title{font-family:'Syne',sans-serif;font-weight:800;font-size:1.5rem;margin-bottom:1.5rem}
    .layout{display:grid;grid-template-columns:240px 1fr;gap:1.5rem;align-items:start}
    .card{background:#fff;border-radius:var(--radius);border:.5px solid #E5E5E0;overflow:hidden}
    .profile-head{padding:1.5rem;text-align:center;border-bottom:.5px solid #F0F0EB}
    .avatar{width:64px;height:64px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-weight:800;font-size:22px;color:#1A1A1A;margin:0 auto .75rem}
    .profile-name{font-family:'Syne',sans-serif;font-weight:700;font-size:15px}
    .profile-email{font-size:12px;color:#888;margin-top:3px}
    .profile-menu{padding:.5rem 0}
    .menu-item{display:flex;align-items:center;gap:.625rem;padding:.625rem 1.25rem;font-size:13px;color:#666;transition:.2s}
    .menu-item:hover,.menu-item.active{color:#1A1A1A;background:#FAFAFA}
    .menu-item i{font-size:16px;color:#888}
    .menu-item.active i{color:var(--primary)}
    .menu-logout{display:flex;align-items:center;gap:.625rem;padding:.625rem 1.25rem;font-size:13px;color:#EF4444;border-top:.5px solid #F0F0EB;margin-top:.5rem}
    .menu-logout:hover{background:#FEF2F2}
    .section-title{font-family:'Syne',sans-serif;font-weight:700;font-size:13px;padding:1rem 1.25rem;border-bottom:.5px solid #F0F0EB}
    .order-row{display:flex;align-items:center;gap:1rem;padding:.875rem 1.25rem;border-bottom:.5px solid #F7F7F5;transition:.2s}
    .order-row:last-child{border-bottom:none}
    .order-row:hover{background:#FAFAFA}
    .order-ref{font-size:12px;font-weight:700;color:#1A1A1A}
    .order-date{font-size:11px;color:#888}
    .order-total{font-family:'Syne',sans-serif;font-weight:800;font-size:13px;color:var(--primary);margin-left:auto}
    .badge{font-size:10px;padding:2px 8px;border-radius:3px;font-weight:700;text-transform:uppercase}
    .badge-wait{background:#FFFBEB;color:#B45309}
    .badge-ok{background:#F0FDF4;color:#16A34A}
    .badge-cancel{background:#FEF2F2;color:#DC2626}
    .empty{text-align:center;padding:2rem;color:#AAA;font-size:13px}
    .empty i{font-size:2.5rem;display:block;margin-bottom:.75rem}
    footer{background:var(--secondary);color:rgba(255,255,255,.3);padding:1.5rem;text-align:center;font-size:12px;margin-top:3rem}
    @media(max-width:768px){.layout{grid-template-columns:1fr}}
  </style>
</head>
<body>

<nav>
  <a href="{{ route('boutique.index', $boutique->slug) }}" class="nav-logo">⬡ {{ $boutique->nom }}</a>
  <div class="nav-right">
    <a href="{{ route('boutique.deconnexion', $boutique->slug) }}" class="tb-btn" style="color:rgba(255,80,80,.7)">
      <i class="ti ti-logout"></i><span>Déconnexion</span>
    </a>
  </div>
</nav>

<div class="main">
  <div class="page-title">Mon compte</div>

  <div class="layout">
    <!-- Sidebar profil -->
    <div class="card">
      <div class="profile-head">
        <div class="avatar">{{ strtoupper(substr($client->prenom ?? 'C', 0, 1).substr($client->nom ?? '', 0, 1)) }}</div>
        <div class="profile-name">{{ $client->prenom }} {{ $client->nom }}</div>
        <div class="profile-email">{{ $client->email }}</div>
      </div>
      <div class="profile-menu">
        <a href="{{ route('boutique.mon-compte', $boutique->slug) }}" class="menu-item active">
          <i class="ti ti-receipt"></i> Mes commandes
        </a>
        <a href="{{ route('boutique.profil', $boutique->slug) }}" class="menu-item">
          <i class="ti ti-user"></i> Mon profil
        </a>
        <a href="{{ route('boutique.panier', $boutique->slug) }}" class="menu-item">
          <i class="ti ti-shopping-cart"></i> Mon panier
        </a>
        <a href="{{ route('boutique.index', $boutique->slug) }}" class="menu-item">
          <i class="ti ti-arrow-left"></i> Retour boutique
        </a>
      </div>
      <a href="{{ route('boutique.deconnexion', $boutique->slug) }}" class="menu-logout">
        <i class="ti ti-logout"></i> Se déconnecter
      </a>
    </div>

    <!-- Commandes -->
    <div class="card">
      <div class="section-title"><i class="ti ti-receipt" style="color:var(--primary)"></i> Mes commandes ({{ $ventes->count() }})</div>
      @forelse($ventes as $v)
      <div class="order-row">
        <div>
          <div class="order-ref">{{ $v->reference }}</div>
          <div class="order-date">{{ $v->created_at->format('d/m/Y à H:i') }}</div>
        </div>
        <span class="badge {{ match($v->statut) {'confirmee'=>'badge-ok','annulee'=>'badge-cancel',default=>'badge-wait'} }}">
          {{ ucfirst($v->statut) }}
        </span>
        <div class="order-total">{{ number_format($v->total_ttc, 0, ',', ' ') }} {{ $boutique->devise }}</div>
      </div>
      @empty
      <div class="empty">
        <i class="ti ti-receipt-off"></i>
        <p>Aucune commande pour l'instant.</p>
        <a href="{{ route('boutique.index', $boutique->slug) }}" style="color:var(--primary);font-weight:600;font-size:12px;display:inline-block;margin-top:.75rem">
          Découvrir nos produits →
        </a>
      </div>
      @endforelse
    </div>
  </div>
</div>

<footer>⬡ {{ $boutique->nom }} · Propulsé par <a href="/" style="color:var(--primary)">BoutiqueConnect</a></footer>
</body>
</html>