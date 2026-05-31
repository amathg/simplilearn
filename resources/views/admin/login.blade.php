<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Connexion — BoutiqueConnect</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: #070709;
      min-height: 100vh;
      display: grid;
      grid-template-columns: 1fr 1fr;
      overflow: hidden;
    }

    /* ── PANNEAU GAUCHE ── */
    .left {
      position: relative;
      background: linear-gradient(145deg, #0d0d14 0%, #111118 100%);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 3rem;
      overflow: hidden;
    }

    .left::before {
      content: '';
      position: absolute;
      top: -30%;
      left: -20%;
      width: 600px;
      height: 600px;
      background: radial-gradient(circle, rgba(245,183,46,.12) 0%, transparent 65%);
      pointer-events: none;
    }

    .left::after {
      content: '';
      position: absolute;
      bottom: -20%;
      right: -10%;
      width: 400px;
      height: 400px;
      background: radial-gradient(circle, rgba(245,183,46,.06) 0%, transparent 65%);
      pointer-events: none;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 10px;
      position: relative;
      z-index: 1;
    }

    .brand-icon {
      width: 38px;
      height: 38px;
      background: #F5B72E;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      color: #0d0d14;
      font-weight: 900;
    }

    .brand-name {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 18px;
      color: #fff;
      letter-spacing: -.3px;
    }

    .brand-name span { color: #F5B72E; }

    .left-content {
      position: relative;
      z-index: 1;
    }

    .left-content h1 {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: clamp(2rem, 3.5vw, 3rem);
      color: #fff;
      line-height: 1.1;
      margin-bottom: 1.25rem;
    }

    .left-content h1 em {
      font-style: normal;
      color: #F5B72E;
    }

    .left-content p {
      font-size: 15px;
      color: rgba(255,255,255,.4);
      line-height: 1.7;
      max-width: 380px;
    }

    .stats {
      display: flex;
      gap: 2rem;
      position: relative;
      z-index: 1;
    }

    .stat strong {
      font-family: 'Syne', sans-serif;
      font-size: 1.5rem;
      font-weight: 800;
      color: #F5B72E;
      display: block;
    }

    .stat span {
      font-size: 11px;
      color: rgba(255,255,255,.3);
      text-transform: uppercase;
      letter-spacing: .5px;
    }

    /* ── PANNEAU DROIT ── */
    .right {
      background: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 3rem 2rem;
    }

    .form-box {
      width: 100%;
      max-width: 380px;
    }

    .form-title {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 1.75rem;
      color: #0d0d14;
      margin-bottom: .375rem;
    }

    .form-sub {
      font-size: 14px;
      color: #999;
      margin-bottom: 2.5rem;
    }

    .fg {
      margin-bottom: 1.25rem;
    }

    .fg label {
      display: block;
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .75px;
      color: #555;
      margin-bottom: .5rem;
    }

    .input-wrap {
      position: relative;
    }

    .input-wrap i {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 17px;
      color: #CCC;
      pointer-events: none;
      transition: color .2s;
    }

    .fg input {
      width: 100%;
      padding: 13px 14px 13px 44px;
      border: 1.5px solid #EBEBEB;
      border-radius: 10px;
      font-size: 14px;
      font-family: 'DM Sans', sans-serif;
      color: #1A1A1A;
      background: #FAFAFA;
      outline: none;
      transition: all .2s;
    }

    .fg input:focus {
      border-color: #F5B72E;
      background: #fff;
      box-shadow: 0 0 0 4px rgba(245,183,46,.1);
    }

    .fg input:focus + i,
    .input-wrap:focus-within i {
      color: #F5B72E;
    }

    .btn-submit {
      width: 100%;
      background: #F5B72E;
      color: #0d0d14;
      font-weight: 800;
      font-size: 14px;
      letter-spacing: .5px;
      padding: 14px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      font-family: 'DM Sans', sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: all .2s;
      margin-top: 1.75rem;
    }

    .btn-submit:hover {
      background: #D99E1A;
      transform: translateY(-1px);
      box-shadow: 0 8px 24px rgba(245,183,46,.3);
    }

    .btn-submit:active {
      transform: translateY(0);
    }

    .err {
      background: #FEF2F2;
      border: 1.5px solid #FECACA;
      border-radius: 10px;
      padding: 12px 16px;
      font-size: 13px;
      color: #DC2626;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .back-link {
      text-align: center;
      margin-top: 2rem;
      font-size: 13px;
      color: #AAA;
    }

    .back-link a {
      color: #F5B72E;
      font-weight: 600;
      text-decoration: none;
    }

    .back-link a:hover { text-decoration: underline; }

    /* Séparateur décoratif */
    .divider {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin: 1.75rem 0 0;
    }

    .divider::before, .divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: #EBEBEB;
    }

    .divider span {
      font-size: 12px;
      color: #CCC;
    }

    @media (max-width: 768px) {
      body { grid-template-columns: 1fr; }
      .left { display: none; }
      .right { min-height: 100vh; }
    }
  </style>
</head>
<body>

  <!-- PANNEAU GAUCHE -->
  <div class="left">
    <div class="brand">
      <div class="brand-icon">⬡</div>
      <div class="brand-name">Boutique<span>Connect</span></div>
    </div>

    <div class="left-content">
      <h1>Gérez votre boutique.<br>Vendez <em>partout.</em></h1>
      <p>Plateforme tout-en-un pour les commerçants africains. Caisse, stock, comptabilité, boutique en ligne.</p>
    </div>

    <div class="stats">
      <div class="stat"><strong>500+</strong><span>Boutiques</span></div>
      <div class="stat"><strong>14j</strong><span>Essai gratuit</span></div>
      <div class="stat"><strong>99.9%</strong><span>Dispo</span></div>
    </div>
  </div>

  <!-- PANNEAU DROIT -->
  <div class="right">
    <div class="form-box">
      <h2 class="form-title">Bon retour 👋</h2>
      <p class="form-sub">Connectez-vous à votre espace administrateur.</p>

      @if($errors->any())
      <div class="err">
        <i class="ti ti-alert-circle" style="font-size:18px;flex-shrink:0"></i>
        {{ $errors->first() }}
      </div>
      @endif

      <form method="POST" action="{{ route('admin.login.store') }}">
        @csrf

        <div class="fg">
          <label>Identifiant</label>
          <div class="input-wrap">
            <input type="text" name="login" value="{{ old('login') }}" required autofocus placeholder="votre identifiant">
            <i class="ti ti-user"></i>
          </div>
        </div>

        <div class="fg">
          <label>Mot de passe</label>
          <div class="input-wrap">
            <input type="password" name="mot_de_passe" required placeholder="••••••••">
            <i class="ti ti-lock"></i>
          </div>
        </div>

        <button type="submit" class="btn-submit">
          <i class="ti ti-login" style="font-size:18px"></i>
          Se connecter
        </button>
      </form>

      <div class="back-link">
        Pas encore de compte ? <a href="{{ route('inscription') }}">Créer une boutique</a>
      </div>

      <div class="divider"><span>ou</span></div>

      <div style="text-align:center;margin-top:1rem">
        <a href="{{ route('home') }}" style="font-size:13px;color:#AAA;text-decoration:none;display:inline-flex;align-items:center;gap:5px">
          <i class="ti ti-arrow-left" style="font-size:14px"></i> Retour à l'accueil
        </a>
      </div>
    </div>
  </div>

</body>
</html>