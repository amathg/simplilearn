<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title', 'Admin') — {{ session('boutique.nom', 'BoutiqueConnect') }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
  <style>
    :root {
      --primary: {{ session('boutique.couleur_primaire', '#F5B72E') }};
      --dark:#0A0A0A; --dark-2:#111; --dark-3:#1A1A1A;
      --gray:#666; --light:#F5F5F0; --white:#FFF;
      --green:#22C55E; --red:#EF4444; --blue:#3B82F6;
      --radius:6px; --sidebar-w:240px;
    }
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    html,body{height:100%;font-family:'DM Sans',sans-serif;background:#F5F5F0;color:#1A1A1A;overflow:hidden}
    a{text-decoration:none}
    .sidebar{width:var(--sidebar-w);background:var(--dark);position:fixed;top:0;left:0;height:100vh;z-index:50;display:flex;flex-direction:column;overflow:hidden}
    .sb-logo{padding:1.25rem;border-bottom:.5px solid rgba(255,255,255,.06)}
    .sb-logo a{font-family:'Syne',sans-serif;font-weight:800;font-size:15px;color:var(--primary);display:block}
    .sb-logo small{font-size:10px;color:rgba(255,255,255,.25);margin-top:3px;display:block}
    .sb-nav{flex:1;overflow-y:auto;padding:.5rem 0;scrollbar-width:none;overscroll-behavior:contain}
    .sb-nav::-webkit-scrollbar{display:none}
    .nav-sec{font-size:9px;color:rgba(255,255,255,.2);text-transform:uppercase;letter-spacing:1.5px;padding:.875rem 1.25rem .375rem;font-weight:700}
    .nav-item{display:flex;align-items:center;gap:10px;padding:.55rem 1.25rem;font-size:13px;color:rgba(255,255,255,.5);transition:all .15s;border-left:2px solid transparent;text-decoration:none}
    .nav-item:hover,.nav-item.active{color:#fff;background:rgba(255,255,255,.05)}
    .nav-item.active{border-left-color:var(--primary);color:var(--primary)}
    .nav-item i{font-size:17px;width:20px;flex-shrink:0}
    .sb-foot{padding:1rem 1.25rem;border-top:.5px solid rgba(255,255,255,.06)}
    .sb-user{display:flex;align-items:center;gap:10px;background:rgba(255,255,255,.05);border-radius:var(--radius);padding:8px 10px;margin-bottom:.75rem}
    .sb-avatar{width:32px;height:32px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;font-weight:800;font-size:12px;color:var(--dark)}
    .sb-user-name{font-size:12px;font-weight:600;color:#fff}
    .sb-user-role{font-size:10px;color:rgba(255,255,255,.3)}
    .sb-foot-btns{display:flex;gap:6px}
    .sb-btn{flex:1;text-align:center;padding:6px;border-radius:4px;font-size:11px;color:rgba(255,255,255,.4);display:flex;align-items:center;justify-content:center;gap:4px;transition:.15s;background:none;cursor:pointer;border:none;font-family:'DM Sans',sans-serif;text-decoration:none}
    .sb-btn:hover{background:rgba(255,255,255,.06);color:#fff}
    .sb-btn.danger{color:var(--red)}
    .sb-btn.danger:hover{background:rgba(239,68,68,.1)}
    .main{margin-left:var(--sidebar-w);height:100vh;overflow-y:auto;display:flex;flex-direction:column}
    .topbar{background:#fff;border-bottom:.5px solid #E5E5E0;padding:.75rem 1.75rem;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:40}
    .topbar-title{font-family:'Syne',sans-serif;font-weight:700;font-size:15px}
    .topbar-right{display:flex;align-items:center;gap:.75rem}
    .topbar-btn{display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:var(--radius);font-size:12px;font-weight:700;transition:.2s;cursor:pointer;font-family:'DM Sans',sans-serif;border:none;text-decoration:none}
    .btn-boutique{background:var(--primary);color:var(--dark)}
    .btn-boutique:hover{opacity:.85}
    .btn-logout{background:#FEF2F2;color:var(--red);border:.5px solid #FECACA}
    .btn-logout:hover{background:#FEE2E2}
    .content{padding:1.75rem;flex:1;min-height:0}
    .card{background:#fff;border:.5px solid #E5E5E0;border-radius:var(--radius);overflow:hidden;margin-bottom:1.5rem}
    .card-head{padding:1rem 1.25rem;border-bottom:.5px solid #F0F0EB;display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap}
    .card-head h2{font-family:'Syne',sans-serif;font-weight:700;font-size:13px;display:flex;align-items:center;gap:8px;margin:0}
    .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:1rem;margin-bottom:1.5rem}
    .stat-card{background:#fff;border:.5px solid #E5E5E0;border-radius:var(--radius);padding:1.25rem;display:flex;align-items:center;gap:1rem}
    .stat-icon{width:44px;height:44px;border-radius:var(--radius);display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0}
    .stat-val{font-family:'Syne',sans-serif;font-size:22px;font-weight:800;display:block}
    .stat-lbl{font-size:11px;color:#888;text-transform:uppercase;letter-spacing:.5px;margin-top:4px;display:block}
    table{width:100%;border-collapse:collapse;font-size:13px}
    th{text-align:left;padding:.6rem 1rem;font-size:10px;text-transform:uppercase;color:#888;background:#FAFAFA;border-bottom:.5px solid #F0F0EB}
    td{padding:.65rem 1rem;border-bottom:.5px solid #F7F7F5;vertical-align:middle}
    tr:last-child td{border-bottom:none}
    tr:hover td{background:#FAFAFA}
    .f-grid{display:flex;flex-direction:column;gap:.875rem}
    .fg{display:flex;flex-direction:column;gap:5px}
    .fg label{font-size:11px;text-transform:uppercase;letter-spacing:.5px;color:#666;font-weight:700}
    .fg input,.fg select,.fg textarea{border:.5px solid #DDD;border-radius:var(--radius);padding:9px 11px;font-size:13px;font-family:'DM Sans',sans-serif;color:#1A1A1A;background:#fff;outline:none;transition:border-color .2s;width:100%}
    .fg input:focus,.fg select:focus,.fg textarea:focus{border-color:var(--primary)}
    .row2{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
    .row3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem}
    .btn{display:inline-flex;align-items:center;gap:6px;border-radius:var(--radius);font-weight:600;font-family:'DM Sans',sans-serif;cursor:pointer;transition:all .2s;border:none;font-size:13px;padding:8px 16px;text-decoration:none}
    .btn-gold{background:var(--primary);color:var(--dark)}
    .btn-gold:hover{opacity:.85}
    .btn-red{background:transparent;color:var(--red);border:.5px solid var(--red) !important}
    .btn-red:hover{background:rgba(239,68,68,.06)}
    .btn-blue{background:var(--blue);color:#fff}
    .btn-sm{padding:5px 12px;font-size:12px}
    .btn-xs{padding:4px 8px;font-size:11px}
    .badge{font-size:10px;padding:2px 8px;border-radius:3px;font-weight:700;text-transform:uppercase;color:#fff;display:inline-block}
    .badge-success{background:var(--green)}
    .badge-warning{background:#F59E0B}
    .badge-danger{background:var(--red)}
    .badge-info{background:var(--blue)}
    .badge-gray{background:#999}
    .badge-dark{background:#1A1A1A}
    .alert-ok{background:#F0FDF4;border:.5px solid #BBF7D0;border-radius:var(--radius);padding:10px 14px;font-size:13px;color:#166534;margin-bottom:1rem;display:flex;align-items:center;gap:8px}
    .alert-ko{background:#FEF2F2;border:.5px solid #FECACA;border-radius:var(--radius);padding:10px 14px;font-size:13px;color:#991B1B;margin-bottom:1rem;display:flex;align-items:center;gap:8px}
    .page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem}
    .page-header h1{font-family:'Syne',sans-serif;font-weight:800;font-size:1.5rem}
    .empty-state{text-align:center;padding:4rem 2rem;color:#AAA}
    .empty-state i{font-size:3rem;display:block;margin-bottom:1rem}
    @media(max-width:900px){.sidebar{transform:translateX(-100%)}.main{margin-left:0}}
  </style>
  @stack('styles')
</head>
<body>

<aside class="sidebar">
  <div class="sb-logo">
    <a href="{{ session('admin_id') ? route('admin.dashboard') : '/' }}">
      ⬡ {{ session('boutique.nom', 'BoutiqueConnect') }}
    </a>
    <small>{{ ucfirst(session('plan.slug', '')) }} · Administration</small>
  </div>

  @if(session('admin_id'))
  <nav class="sb-nav">
    <div class="nav-sec">Tableau de bord</div>
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <i class="ti ti-dashboard"></i><span>Vue d'ensemble</span>
    </a>

    <div class="nav-sec">Catalogue</div>
    <a href="{{ route('admin.produits.index') }}" class="nav-item {{ request()->routeIs('admin.produits*') ? 'active' : '' }}">
      <i class="ti ti-package"></i><span>Produits</span>
    </a>
    <a href="{{ route('admin.marques.index') }}" class="nav-item {{ request()->routeIs('admin.marques*') ? 'active' : '' }}">
      <i class="ti ti-bookmark"></i><span>Marques</span>
    </a>

    <div class="nav-sec">Stocks</div>
    <a href="{{ route('admin.stocks.index') }}" class="nav-item {{ request()->routeIs('admin.stocks*') ? 'active' : '' }}">
      <i class="ti ti-building-warehouse"></i><span>Stocks</span>
    </a>
    <a href="{{ route('admin.magasins.index') }}" class="nav-item {{ request()->routeIs('admin.magasins*') ? 'active' : '' }}">
      <i class="ti ti-building-store"></i><span>Magasins</span>
    </a>
    <a href="{{ route('admin.inventaires.index') }}" class="nav-item {{ request()->routeIs('admin.inventaires*') ? 'active' : '' }}">
      <i class="ti ti-clipboard-list"></i><span>Inventaires</span>
    </a>

    <div class="nav-sec">Achats</div>
    <a href="{{ route('admin.fournisseurs.index') }}" class="nav-item {{ request()->routeIs('admin.fournisseurs*') ? 'active' : '' }}">
      <i class="ti ti-truck-delivery"></i><span>Fournisseurs</span>
    </a>
    <a href="{{ route('admin.achats.index') }}" class="nav-item {{ request()->routeIs('admin.achats*') ? 'active' : '' }}">
      <i class="ti ti-shopping-cart"></i><span>Commandes achat</span>
    </a>

    <div class="nav-sec">Ventes</div>
    <a href="{{ route('admin.ventes.pos') }}" class="nav-item {{ request()->routeIs('admin.ventes.pos') ? 'active' : '' }}">
      <i class="ti ti-device-desktop"></i><span>Point de vente</span>
    </a>
    <a href="{{ route('admin.ventes.index') }}" class="nav-item {{ request()->routeIs('admin.ventes.index') ? 'active' : '' }}">
      <i class="ti ti-receipt"></i><span>Commandes</span>
    </a>
    <a href="{{ route('admin.ventes.credits') }}" class="nav-item {{ request()->routeIs('admin.ventes.credits') ? 'active' : '' }}">
      <i class="ti ti-credit-card"></i><span>Ventes à crédit</span>
    </a>

    <div class="nav-sec">Caisse</div>
    <a href="{{ route('admin.caisse.index') }}" class="nav-item {{ request()->routeIs('admin.caisse*') ? 'active' : '' }}">
      <i class="ti ti-cash-register"></i><span>Caisse</span>
    </a>

    <div class="nav-sec">Finances</div>
    <a href="{{ route('admin.depenses.index') }}" class="nav-item {{ request()->routeIs('admin.depenses*') ? 'active' : '' }}">
      <i class="ti ti-wallet"></i><span>Dépenses</span>
    </a>
    <a href="{{ route('admin.comptabilite.index') }}" class="nav-item {{ request()->routeIs('admin.comptabilite*') ? 'active' : '' }}">
      <i class="ti ti-calculator"></i><span>Comptabilité</span>
    </a>

    <div class="nav-sec">RH</div>
    <a href="{{ route('admin.employes.index') }}" class="nav-item {{ request()->routeIs('admin.employes*') ? 'active' : '' }}">
      <i class="ti ti-users"></i><span>Employés</span>
    </a>
    <a href="{{ route('admin.conges.index') }}" class="nav-item {{ request()->routeIs('admin.conges*') ? 'active' : '' }}">
      <i class="ti ti-calendar-off"></i><span>Congés</span>
    </a>
    <a href="{{ route('admin.paie.index') }}" class="nav-item {{ request()->routeIs('admin.paie*') ? 'active' : '' }}">
      <i class="ti ti-coins"></i><span>Paie</span>
    </a>
    <a href="{{ route('admin.avances.index') }}" class="nav-item {{ request()->routeIs('admin.avances*') ? 'active' : '' }}">
      <i class="ti ti-cash"></i><span>Avances</span>
    </a>

    <div class="nav-sec">CRM</div>
    <a href="{{ route('admin.clients.index') }}" class="nav-item {{ request()->routeIs('admin.clients*') ? 'active' : '' }}">
      <i class="ti ti-users-group"></i><span>Clients</span>
    </a>
    <a href="{{ route('admin.fidelite.index') }}" class="nav-item {{ request()->routeIs('admin.fidelite*') ? 'active' : '' }}">
      <i class="ti ti-heart"></i><span>Fidélité</span>
    </a>

    <div class="nav-sec">Opérations</div>
    <a href="{{ route('admin.livraisons.index') }}" class="nav-item {{ request()->routeIs('admin.livraisons*') ? 'active' : '' }}">
      <i class="ti ti-truck"></i><span>Livraisons</span>
    </a>
    <a href="{{ route('admin.sav.index') }}" class="nav-item {{ request()->routeIs('admin.sav*') ? 'active' : '' }}">
      <i class="ti ti-headset"></i><span>SAV & Retours</span>
    </a>

    <div class="nav-sec">Analyse</div>
    <a href="{{ route('admin.reporting.index') }}" class="nav-item {{ request()->routeIs('admin.reporting*') ? 'active' : '' }}">
      <i class="ti ti-chart-bar"></i><span>Reporting</span>
    </a>
    <div class="nav-sec" style="margin-top:.5rem">IA &amp; Marketing</div>
    <a href="{{ route('admin.agent-ia.index') }}" class="nav-item {{ request()->routeIs('admin.agent-ia*') ? 'active' : '' }}">
      <i class="ti ti-sparkles"></i><span>Agent IA Pub</span>
    </a>

    <div class="nav-sec">Configuration</div>
    <a href="{{ route('admin.parametres.index') }}" class="nav-item {{ request()->routeIs('admin.parametres*') ? 'active' : '' }}">
      <i class="ti ti-settings"></i><span>Paramètres</span>
    </a>
    <a href="{{ route('admin.roles.index') }}" class="nav-item {{ request()->routeIs('admin.roles*') ? 'active' : '' }}">
      <i class="ti ti-shield"></i><span>Rôles & Droits</span>
    </a>
  </nav>

  <div class="sb-foot">
    <div class="sb-user">
      <div class="sb-avatar">{{ strtoupper(substr(session('admin_login', 'A'), 0, 1)) }}</div>
      <div>
        <div class="sb-user-name">{{ session('admin_login') }}</div>
        <div class="sb-user-role">{{ ucfirst(session('admin_role', 'Admin')) }}</div>
      </div>
    </div>
    <div class="sb-foot-btns">
      <a href="{{ route('admin.parametres.index') }}" class="sb-btn">
        <i class="ti ti-settings"></i> Paramètres
      </a>
      <form method="POST" action="{{ route('admin.logout') }}" style="flex:1">
        @csrf
        <button type="submit" class="sb-btn danger" style="width:100%">
          <i class="ti ti-logout"></i> Quitter
        </button>
      </form>
    </div>
  </div>
  @endif
</aside>

<div class="main">
  <div class="topbar">
    <div class="topbar-title">@yield('title', 'Admin')</div>
    <div class="topbar-right">
      @if(session('boutique.slug'))
      <a href="{{ route('boutique.index', session('boutique.slug')) }}" target="_blank" class="topbar-btn btn-boutique">
        <i class="ti ti-external-link"></i> Ma boutique
      </a>
      @endif
      @if(session('admin_id'))
      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit" class="topbar-btn btn-logout">
          <i class="ti ti-logout"></i> Déconnexion
        </button>
      </form>
      @endif
    </div>
  </div>
  <div class="content">
    @yield('content')
  </div>
</div>

@stack('scripts')

<script>
// Garder la position de scroll de la sidebar
const SCROLL_KEY = 'sidebar_scroll';
const nav = document.querySelector('.sb-nav');

// Restaurer la position au chargement
if (nav) {
    const saved = sessionStorage.getItem(SCROLL_KEY);
    if (saved) nav.scrollTop = parseInt(saved);
}

// Sauvegarder la position avant de quitter
window.addEventListener('beforeunload', () => {
    if (nav) sessionStorage.setItem(SCROLL_KEY, nav.scrollTop);
});

// Sauvegarder aussi au clic sur les liens
document.querySelectorAll('.nav-item').forEach(link => {
    link.addEventListener('click', () => {
        if (nav) sessionStorage.setItem(SCROLL_KEY, nav.scrollTop);
    });
});
</script>
</body>
</html>