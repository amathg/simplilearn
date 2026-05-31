<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Créer un compte — {{ $boutique->nom }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/tabler-icons/tabler-icons.min.css">
  <style>
    :root{--primary:{{ $boutique->couleur_primaire ?? '#F5B72E' }};--secondary:{{ $boutique->couleur_secondaire ?? '#1A1A1A' }};--radius:8px}
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'DM Sans',sans-serif;background:#F5F5F0;color:#1A1A1A;min-height:100vh;display:flex;flex-direction:column}
    a{text-decoration:none;color:inherit}
    nav{background:var(--secondary);padding:.875rem 1.5rem;display:flex;align-items:center;justify-content:space-between}
    .nav-logo{font-family:'Syne',sans-serif;font-weight:800;font-size:16px;color:var(--primary)}
    .main{flex:1;display:flex;align-items:center;justify-content:center;padding:2rem 1.5rem}
    .box{background:#fff;border-radius:var(--radius);border:.5px solid #E5E5E0;padding:2rem;width:100%;max-width:440px}
    .box-title{font-family:'Syne',sans-serif;font-weight:800;font-size:1.25rem;margin-bottom:.25rem}
    .box-sub{font-size:13px;color:#888;margin-bottom:1.5rem}
    .row2{display:grid;grid-template-columns:1fr 1fr;gap:.75rem}
    .fg{display:flex;flex-direction:column;gap:5px;margin-bottom:.875rem}
    .fg label{font-size:11px;text-transform:uppercase;letter-spacing:.5px;color:#666;font-weight:700}
    .fg input{border:.5px solid #DDD;border-radius:var(--radius);padding:10px 12px;font-size:13px;font-family:'DM Sans',sans-serif;color:#1A1A1A;outline:none;transition:border-color .2s;width:100%}
    .fg input:focus{border-color:var(--primary)}
    .btn{display:block;background:var(--primary);color:#1A1A1A;border:none;border-radius:var(--radius);padding:12px;font-size:14px;font-weight:700;cursor:pointer;font-family:'DM Sans',sans-serif;text-align:center;width:100%;transition:.2s;margin-top:.5rem}
    .btn:hover{opacity:.85}
    .alert-ko{background:#FEF2F2;border:.5px solid #FECACA;border-radius:var(--radius);padding:10px 14px;font-size:13px;color:#991B1B;margin-bottom:1rem;display:flex;align-items:center;gap:8px}
    .divider{display:flex;align-items:center;gap:1rem;margin:1.25rem 0;font-size:12px;color:#CCC}
    .divider::before,.divider::after{content:'';flex:1;border-top:.5px solid #EEE}
    .link{color:var(--primary);font-weight:600;font-size:13px;text-align:center;display:block;margin-top:.75rem}
    footer{background:var(--secondary);color:rgba(255,255,255,.3);padding:1rem;text-align:center;font-size:12px}
  </style>
</head>
<body>
<nav>
  <a href="{{ route('boutique.index', $boutique->slug) }}" class="nav-logo">⬡ {{ $boutique->nom }}</a>
</nav>
<div class="main">
  <div class="box">
    <div class="box-title">Créer un compte</div>
    <div class="box-sub">Rejoignez {{ $boutique->nom }} pour suivre vos commandes</div>

    @if($errors->any())
    <div class="alert-ko"><i class="ti ti-alert-circle"></i> {{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('boutique.inscription.store', $boutique->slug) }}">
      @csrf
      <div class="row2">
        <div class="fg"><label>Prénom *</label><input type="text" name="prenom" value="{{ old('prenom') }}" required autofocus></div>
        <div class="fg"><label>Nom *</label><input type="text" name="nom" value="{{ old('nom') }}" required></div>
      </div>
      <div class="fg"><label>Email *</label><input type="email" name="email" value="{{ old('email') }}" required placeholder="votre@email.com"></div>
      <div class="fg"><label>Téléphone</label><input type="tel" name="telephone" value="{{ old('telephone') }}" placeholder="ex: 77 123 45 67"></div>
      <div class="fg"><label>Mot de passe *</label><input type="password" name="password" required placeholder="Minimum 6 caractères"></div>
      <div class="fg"><label>Confirmer le mot de passe *</label><input type="password" name="password_confirmation" required placeholder="••••••••"></div>
      <button type="submit" class="btn"><i class="ti ti-user-plus"></i> Créer mon compte</button>
    </form>

    <div class="divider">Déjà un compte ?</div>
    <a href="{{ route('boutique.connexion', $boutique->slug) }}" class="link">
      <i class="ti ti-login"></i> Se connecter
    </a>
  </div>
</div>
<footer>⬡ {{ $boutique->nom }} · Propulsé par <a href="/" style="color:var(--primary)">BoutiqueConnect</a></footer>
</body>
</html>