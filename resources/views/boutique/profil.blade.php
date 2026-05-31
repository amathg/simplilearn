<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Mon profil — {{ $boutique->nom }}</title>
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
    .card{background:#fff;border-radius:var(--radius);border:.5px solid #E5E5E0;overflow:hidden;margin-bottom:1rem}
    .profile-head{padding:1.5rem;text-align:center;border-bottom:.5px solid #F0F0EB}
    .avatar{width:72px;height:72px;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-weight:800;font-size:24px;color:#1A1A1A;margin:0 auto .75rem}
    .profile-name{font-family:'Syne',sans-serif;font-weight:700;font-size:15px}
    .profile-email{font-size:12px;color:#888;margin-top:3px}
    .profile-menu{padding:.5rem 0}
    .menu-item{display:flex;align-items:center;gap:.625rem;padding:.625rem 1.25rem;font-size:13px;color:#666;transition:.2s}
    .menu-item:hover,.menu-item.active{color:#1A1A1A;background:#FAFAFA}
    .menu-item i{font-size:16px;color:#888}
    .menu-item.active i{color:var(--primary)}
    .menu-logout{display:flex;align-items:center;gap:.625rem;padding:.625rem 1.25rem;font-size:13px;color:#EF4444;border-top:.5px solid #F0F0EB;margin-top:.5rem}
    .menu-logout:hover{background:#FEF2F2}
    .card-head{padding:1rem 1.25rem;border-bottom:.5px solid #F0F0EB;font-family:'Syne',sans-serif;font-weight:700;font-size:13px}
    .card-body{padding:1.25rem}
    .fg{display:flex;flex-direction:column;gap:5px;margin-bottom:.875rem}
    .fg label{font-size:11px;text-transform:uppercase;letter-spacing:.5px;color:#666;font-weight:700}
    .fg input{border:.5px solid #DDD;border-radius:var(--radius);padding:10px 12px;font-size:13px;font-family:'DM Sans',sans-serif;color:#1A1A1A;outline:none;transition:border-color .2s;width:100%}
    .fg input:focus{border-color:var(--primary)}
    .row2{display:grid;grid-template-columns:1fr 1fr;gap:.875rem}
    .btn{display:inline-flex;align-items:center;gap:6px;background:var(--primary);color:#1A1A1A;border:none;border-radius:var(--radius);padding:10px 20px;font-size:13px;font-weight:700;cursor:pointer;font-family:'DM Sans',sans-serif;transition:.2s}
    .btn:hover{opacity:.85}
    .alert-ok{background:#F0FDF4;border:.5px solid #BBF7D0;border-radius:var(--radius);padding:10px 14px;font-size:13px;color:#166534;margin-bottom:1rem;display:flex;align-items:center;gap:8px}
    .alert-ko{background:#FEF2F2;border:.5px solid #FECACA;border-radius:var(--radius);padding:10px 14px;font-size:13px;color:#991B1B;margin-bottom:1rem;display:flex;align-items:center;gap:8px}
    footer{background:var(--secondary);color:rgba(255,255,255,.3);padding:1.5rem;text-align:center;font-size:12px;margin-top:3rem}
    @media(max-width:768px){.layout{grid-template-columns:1fr}.row2{grid-template-columns:1fr}}
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
  <div class="page-title">Mon profil</div>

  @if(session('ok'))
  <div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
  @endif
  @if($errors->any())
  <div class="alert-ko"><i class="ti ti-alert-circle"></i> {{ $errors->first() }}</div>
  @endif

  <div class="layout">
    <!-- Sidebar -->
    <div class="card">
      <div class="profile-head">
        <div class="avatar">{{ strtoupper(substr($client->prenom ?? 'C', 0, 1).substr($client->nom ?? '', 0, 1)) }}</div>
        <div class="profile-name">{{ $client->prenom }} {{ $client->nom }}</div>
        <div class="profile-email">{{ $client->email }}</div>
      </div>
      <div class="profile-menu">
        <a href="{{ route('boutique.mon-compte', $boutique->slug) }}" class="menu-item">
          <i class="ti ti-receipt"></i> Mes commandes
        </a>
        <a href="{{ route('boutique.profil', $boutique->slug) }}" class="menu-item active">
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

    <div>
      <!-- Informations personnelles -->
      <div class="card">
        <div class="card-head"><i class="ti ti-user" style="color:var(--primary)"></i> Informations personnelles</div>
        <div class="card-body">
          <form method="POST" action="{{ route('boutique.profil.update', $boutique->slug) }}">
            @csrf
            <div class="row2">
              <div class="fg">
                <label>Prénom *</label>
                <input type="text" name="prenom" value="{{ old('prenom', $client->prenom) }}" required>
              </div>
              <div class="fg">
                <label>Nom *</label>
                <input type="text" name="nom" value="{{ old('nom', $client->nom) }}" required>
              </div>
            </div>
            <div class="fg">
              <label>Email *</label>
              <input type="email" name="email" value="{{ old('email', $client->email) }}" required>
            </div>
            <div class="fg">
              <label>Téléphone</label>
              <input type="tel" name="telephone" value="{{ old('telephone', $client->telephone) }}" placeholder="ex: 77 123 45 67">
            </div>
            <div class="fg">
              <label>Adresse</label>
              <input type="text" name="adresse" value="{{ old('adresse', $client->adresse) }}" placeholder="Votre adresse de livraison">
            </div>
            <button type="submit" class="btn">
              <i class="ti ti-device-floppy"></i> Enregistrer les modifications
            </button>
          </form>
        </div>
      </div>

      <!-- Changer mot de passe -->
      <div class="card">
        <div class="card-head"><i class="ti ti-lock" style="color:var(--primary)"></i> Changer le mot de passe</div>
        <div class="card-body">
          <form method="POST" action="{{ route('boutique.profil.password', $boutique->slug) }}">
            @csrf
            <div class="fg">
              <label>Mot de passe actuel *</label>
              <input type="password" name="password_actuel" required placeholder="••••••••">
            </div>
            <div class="fg">
              <label>Nouveau mot de passe *</label>
              <input type="password" name="password" required placeholder="Minimum 6 caractères">
            </div>
            <div class="fg">
              <label>Confirmer le nouveau mot de passe *</label>
              <input type="password" name="password_confirmation" required placeholder="••••••••">
            </div>
            <button type="submit" class="btn">
              <i class="ti ti-lock-check"></i> Changer le mot de passe
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<footer>⬡ {{ $boutique->nom }} · Propulsé par <a href="/" style="color:var(--primary)">BoutiqueConnect</a></footer>
</body>
</html>