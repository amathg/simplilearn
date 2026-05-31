<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Créer votre boutique — BoutiqueConnect</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --gold: #F5B72E;
      --gold-d: #D99E1A;
      --dark: #070709;
      --dark-2: #0E0E12;
      --dark-3: #161619;
      --dark-4: #1E1E23;
      --border: rgba(255,255,255,.07);
      --text: rgba(255,255,255,.9);
      --text-2: rgba(255,255,255,.45);
      --text-3: rgba(255,255,255,.2);
      --green: #22C55E;
      --radius: 12px;
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--dark);
      color: var(--text);
      min-height: 100vh;
    }

    /* ── NAV ── */
    nav {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1.25rem 2.5rem;
      border-bottom: 1px solid var(--border);
      position: sticky;
      top: 0;
      z-index: 50;
      background: rgba(7,7,9,.85);
      backdrop-filter: blur(20px);
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
    }

    .brand-icon {
      width: 36px;
      height: 36px;
      background: var(--gold);
      border-radius: 9px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      color: var(--dark);
      font-weight: 900;
    }

    .brand-name {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 17px;
      color: #fff;
    }

    .brand-name span { color: var(--gold); }

    .nav-right {
      display: flex;
      align-items: center;
      gap: 1.25rem;
      font-size: 13px;
    }

    .nav-right span { color: var(--text-2); }

    .btn-login {
      background: rgba(255,255,255,.07);
      color: rgba(255,255,255,.8);
      padding: 8px 18px;
      border-radius: 8px;
      font-size: 13px;
      font-weight: 600;
      text-decoration: none;
      border: 1px solid var(--border);
      transition: all .2s;
    }

    .btn-login:hover {
      background: rgba(255,255,255,.12);
      color: #fff;
    }

    /* ── HERO ── */
    .hero {
      text-align: center;
      padding: 4rem 2rem 2.5rem;
      position: relative;
      overflow: hidden;
    }

    .hero::before {
      content: '';
      position: absolute;
      top: -50%;
      left: 50%;
      transform: translateX(-50%);
      width: 700px;
      height: 400px;
      background: radial-gradient(ellipse, rgba(245,183,46,.08) 0%, transparent 70%);
      pointer-events: none;
    }

    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      background: rgba(245,183,46,.08);
      border: 1px solid rgba(245,183,46,.2);
      border-radius: 50px;
      padding: 5px 16px;
      font-size: 11px;
      color: var(--gold);
      font-weight: 700;
      letter-spacing: .5px;
      text-transform: uppercase;
      margin-bottom: 1.5rem;
    }

    .hero h1 {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: clamp(1.75rem, 4vw, 3rem);
      color: #fff;
      line-height: 1.1;
      margin-bottom: .875rem;
      position: relative;
    }

    .hero h1 em {
      font-style: normal;
      color: var(--gold);
    }

    .hero p {
      font-size: 15px;
      color: var(--text-2);
      max-width: 460px;
      margin: 0 auto;
      line-height: 1.65;
      position: relative;
    }

    /* ── STEPS INDICATOR ── */
    .steps-bar {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0;
      max-width: 500px;
      margin: 2rem auto 0;
      position: relative;
    }

    .step-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 6px;
      flex: 1;
      position: relative;
    }

    .step-item:not(:last-child)::after {
      content: '';
      position: absolute;
      top: 15px;
      left: 55%;
      right: -55%;
      height: 1px;
      background: var(--border);
    }

    .step-num {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      background: var(--dark-3);
      border: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 11px;
      font-weight: 800;
      color: var(--text-3);
      transition: all .3s;
      position: relative;
      z-index: 1;
    }

    .step-item.active .step-num {
      background: var(--gold);
      border-color: var(--gold);
      color: var(--dark);
    }

    .step-item.done .step-num {
      background: var(--green);
      border-color: var(--green);
      color: #fff;
    }

    .step-label {
      font-size: 10px;
      color: var(--text-3);
      text-transform: uppercase;
      letter-spacing: .5px;
      font-weight: 600;
      white-space: nowrap;
    }

    .step-item.active .step-label { color: var(--gold); }

    /* ── CONTAINER ── */
    .container {
      max-width: 820px;
      margin: 0 auto;
      padding: 2rem 1.5rem 5rem;
    }

    /* ── PLANS ── */
    .section-label {
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      color: var(--gold);
      margin-bottom: .75rem;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .section-label::before {
      content: '';
      display: block;
      width: 20px;
      height: 1px;
      background: var(--gold);
    }

    .section-title {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 1.1rem;
      color: #fff;
      margin-bottom: 1.25rem;
    }

    .plans-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: .75rem;
      margin-bottom: 2.5rem;
    }

    .plan-opt input[type=radio] { display: none; }

    .plan-label {
      display: block;
      background: var(--dark-3);
      border: 1.5px solid var(--border);
      border-radius: var(--radius);
      padding: 1.25rem;
      cursor: pointer;
      transition: all .2s;
      position: relative;
      height: 100%;
    }

    .plan-label:hover {
      border-color: rgba(245,183,46,.3);
      background: var(--dark-4);
    }

    .plan-opt input:checked + .plan-label {
      border-color: var(--gold);
      background: rgba(245,183,46,.05);
      box-shadow: 0 0 0 4px rgba(245,183,46,.08), inset 0 1px 0 rgba(245,183,46,.1);
    }

    .plan-check {
      position: absolute;
      top: 10px;
      right: 10px;
      width: 18px;
      height: 18px;
      border-radius: 50%;
      border: 1.5px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all .2s;
      font-size: 9px;
      font-weight: 900;
    }

    .plan-opt input:checked + .plan-label .plan-check {
      background: var(--gold);
      border-color: var(--gold);
      color: var(--dark);
    }

    .plan-opt input:checked + .plan-label .plan-check::after {
      content: '✓';
    }

    .plan-icon {
      width: 38px;
      height: 38px;
      border-radius: 9px;
      background: rgba(255,255,255,.04);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 19px;
      color: var(--text-3);
      margin-bottom: .875rem;
      transition: all .2s;
    }

    .plan-opt input:checked + .plan-label .plan-icon {
      background: rgba(245,183,46,.12);
      color: var(--gold);
    }

    .plan-nom {
      font-family: 'Syne', sans-serif;
      font-weight: 800;
      font-size: 13px;
      color: #fff;
      margin-bottom: 4px;
    }

    .plan-prix {
      font-size: 12px;
      color: var(--gold);
      font-weight: 700;
      margin-bottom: 5px;
    }

    .plan-desc {
      font-size: 10px;
      color: var(--text-3);
      line-height: 1.4;
    }

    /* ── FORM SECTION ── */
    .form-section {
      background: var(--dark-2);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 1.75rem 2rem;
      margin-bottom: 1rem;
    }

    .form-section-head {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 1.5rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid var(--border);
    }

    .form-section-num {
      width: 28px;
      height: 28px;
      background: var(--gold);
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 11px;
      font-weight: 900;
      color: var(--dark);
      flex-shrink: 0;
    }

    .form-section-title {
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 14px;
      color: #fff;
    }

    .form-section-sub {
      font-size: 12px;
      color: var(--text-3);
      margin-top: 2px;
    }

    .row2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

    .fg { margin-bottom: 1rem; }
    .fg:last-child { margin-bottom: 0; }

    .fg label {
      display: block;
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .75px;
      color: var(--text-3);
      margin-bottom: .5rem;
    }

    .input-wrap { position: relative; }

    .input-wrap i {
      position: absolute;
      left: 13px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 16px;
      color: rgba(255,255,255,.15);
      pointer-events: none;
      transition: color .2s;
    }

    .fg input {
      width: 100%;
      padding: 11px 13px 11px 40px;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      font-size: 13px;
      font-family: 'DM Sans', sans-serif;
      color: rgba(255,255,255,.85);
      background: rgba(255,255,255,.03);
      outline: none;
      transition: all .2s;
    }

    .fg input::placeholder { color: rgba(255,255,255,.15); }

    .fg input:focus {
      border-color: var(--gold);
      background: rgba(245,183,46,.03);
      box-shadow: 0 0 0 3px rgba(245,183,46,.08);
    }

    .input-wrap:focus-within i { color: var(--gold); }

    /* ── PASSWORD STRENGTH ── */
    .pwd-hint {
      font-size: 11px;
      color: var(--text-3);
      margin-top: 5px;
    }

    /* ── SUBMIT ── */
    .submit-bar {
      background: var(--dark-2);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 1.5rem 2rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 1rem;
      margin-top: 1rem;
    }

    .submit-info p {
      font-size: 14px;
      color: #fff;
      font-weight: 600;
      margin-bottom: 4px;
    }

    .submit-info small {
      font-size: 12px;
      color: var(--text-3);
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .btn-submit {
      background: var(--gold);
      color: var(--dark);
      font-weight: 800;
      font-size: 14px;
      padding: 13px 32px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      font-family: 'DM Sans', sans-serif;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all .2s;
      white-space: nowrap;
    }

    .btn-submit:hover {
      background: var(--gold-d);
      transform: translateY(-1px);
      box-shadow: 0 8px 24px rgba(245,183,46,.25);
    }

    /* ── ERROR ── */
    .err {
      background: rgba(220,38,38,.08);
      border: 1px solid rgba(220,38,38,.25);
      border-radius: 10px;
      padding: 12px 16px;
      font-size: 13px;
      color: #FCA5A5;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    /* ── FEATURES MINI ── */
    .features-strip {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 2rem;
      padding: 1.5rem;
      border-top: 1px solid var(--border);
      margin-top: 1.5rem;
      flex-wrap: wrap;
    }

    .feature-item {
      display: flex;
      align-items: center;
      gap: 7px;
      font-size: 12px;
      color: var(--text-3);
    }

    .feature-item i { color: var(--green); font-size: 15px; }

    @media (max-width: 768px) {
      nav { padding: 1rem 1.25rem; }
      .plans-grid { grid-template-columns: 1fr 1fr; }
      .row2 { grid-template-columns: 1fr; }
      .form-section { padding: 1.25rem; }
      .submit-bar { flex-direction: column; }
      .btn-submit { width: 100%; justify-content: center; }
    }
  </style>
</head>
<body>

<!-- NAV -->
<nav>
  <a href="{{ route('home') }}" class="brand">
    <div class="brand-icon">⬡</div>
    <div class="brand-name">Boutique<span>Connect</span></div>
  </a>
  <div class="nav-right">
    <span>Déjà un compte ?</span>
    <a href="{{ route('admin.login') }}" class="btn-login">
      <i class="ti ti-login" style="font-size:14px;vertical-align:middle;margin-right:4px"></i>
      Se connecter
    </a>
  </div>
</nav>

<!-- HERO -->
<div class="hero">
  <div class="hero-badge">
    <i class="ti ti-stars" style="font-size:12px"></i>
    14 jours gratuits · Sans carte bancaire
  </div>
  <h1>Créez votre boutique<br><em>en 2 minutes.</em></h1>
  <p>Choisissez votre plan, remplissez vos informations et commencez à vendre immédiatement.</p>
</div>

<!-- FORM -->
<div class="container">

  @if($errors->any())
  <div class="err">
    <i class="ti ti-alert-circle" style="font-size:18px;flex-shrink:0"></i>
    {{ $errors->first() }}
  </div>
  @endif

  <form method="POST" action="{{ route('inscription.store') }}">
    @csrf

    <!-- 01 — PLAN -->
    <p class="section-label">Étape 01</p>
    <h2 class="section-title">Choisissez votre plan</h2>
    <div class="plans-grid">
      @foreach($plans as $plan)
      <div class="plan-opt">
        <input type="radio" name="plan_slug" id="plan_{{ $plan->slug }}"
               value="{{ $plan->slug }}"
               {{ $plan_slug === $plan->slug ? 'checked' : '' }}>
        <label for="plan_{{ $plan->slug }}" class="plan-label">
          <div class="plan-check"></div>
          <div class="plan-icon">
            <i class="ti {{ match($plan->slug) {
              'starter'    => 'ti-rocket',
              'pro'        => 'ti-star',
              'business'   => 'ti-building',
              'enterprise' => 'ti-crown',
              default      => 'ti-package'
            } }}"></i>
          </div>
          <div class="plan-nom">{{ $plan->nom }}</div>
          <div class="plan-prix">{{ number_format($plan->prix_mensuel, 0, ',', ' ') }} <span style="font-weight:400;opacity:.4">FCFA/mois</span></div>
          <div class="plan-desc">{{ $plan->description }}</div>
        </label>
      </div>
      @endforeach
    </div>

    <!-- 02 — BOUTIQUE -->
    <div class="form-section">
      <div class="form-section-head">
        <div class="form-section-num">02</div>
        <div>
          <div class="form-section-title">Informations de la boutique</div>
          <div class="form-section-sub">Ces informations apparaîtront sur votre boutique en ligne</div>
        </div>
      </div>

      <div class="fg">
        <label>Nom de la boutique *</label>
        <div class="input-wrap">
          <input type="text" name="nom_boutique" value="{{ old('nom_boutique') }}" required placeholder="ex: Quincaillerie Khadim">
          <i class="ti ti-building-store"></i>
        </div>
      </div>
      <div class="row2">
        <div class="fg">
          <label>Adresse email *</label>
          <div class="input-wrap">
            <input type="email" name="email" value="{{ old('email') }}" required placeholder="vous@exemple.com">
            <i class="ti ti-mail"></i>
          </div>
        </div>
        <div class="fg">
          <label>Téléphone *</label>
          <div class="input-wrap">
            <input type="tel" name="telephone" value="{{ old('telephone') }}" required placeholder="+221 77 000 00 00">
            <i class="ti ti-phone"></i>
          </div>
        </div>
      </div>
      <div class="fg">
        <label>Ville</label>
        <div class="input-wrap">
          <input type="text" name="ville" value="{{ old('ville') }}" placeholder="ex: Dakar">
          <i class="ti ti-map-pin"></i>
        </div>
      </div>
    </div>

    <!-- 03 — COMPTE -->
    <div class="form-section">
      <div class="form-section-head">
        <div class="form-section-num">03</div>
        <div>
          <div class="form-section-title">Compte administrateur</div>
          <div class="form-section-sub">Ces identifiants serviront à vous connecter à votre espace admin</div>
        </div>
      </div>

      <div class="fg">
        <label>Identifiant de connexion *</label>
        <div class="input-wrap">
          <input type="text" name="login" value="{{ old('login') }}" required placeholder="ex: admin" autocomplete="off">
          <i class="ti ti-user"></i>
        </div>
      </div>
      <div class="row2">
        <div class="fg">
          <label>Mot de passe * (6 min)</label>
          <div class="input-wrap">
            <input type="password" name="mot_de_passe" required placeholder="••••••••" id="pwd">
            <i class="ti ti-lock"></i>
          </div>
          <p class="pwd-hint" id="pwd-hint"></p>
        </div>
        <div class="fg">
          <label>Confirmer le mot de passe *</label>
          <div class="input-wrap">
            <input type="password" name="mot_de_passe_confirmation" required placeholder="••••••••">
            <i class="ti ti-lock-check"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- SUBMIT -->
    <div class="submit-bar">
      <div class="submit-info">
        <p>Prêt à lancer votre boutique ?</p>
        <small>
          <i class="ti ti-shield-check" style="color:var(--green)"></i>
          14 jours gratuits · Sans engagement · Annulable à tout moment
        </small>
      </div>
      <button type="submit" class="btn-submit">
        <i class="ti ti-rocket" style="font-size:18px"></i>
        Créer ma boutique
      </button>
    </div>

    <!-- FEATURES -->
    <div class="features-strip">
      <div class="feature-item"><i class="ti ti-check"></i> Boutique en ligne incluse</div>
      <div class="feature-item"><i class="ti ti-check"></i> Caisse & POS intégrés</div>
      <div class="feature-item"><i class="ti ti-check"></i> Gestion des stocks</div>
      <div class="feature-item"><i class="ti ti-check"></i> Support inclus</div>
    </div>

  </form>
</div>

<script>
// Indicateur force mot de passe
const pwd = document.getElementById('pwd');
const hint = document.getElementById('pwd-hint');
if (pwd && hint) {
  pwd.addEventListener('input', () => {
    const v = pwd.value;
    if (!v) { hint.textContent = ''; return; }
    if (v.length < 6) { hint.style.color = '#EF4444'; hint.textContent = '⚠ Trop court (6 caractères min)'; }
    else if (v.length < 10) { hint.style.color = '#F59E0B'; hint.textContent = '○ Mot de passe acceptable'; }
    else { hint.style.color = '#22C55E'; hint.textContent = '✓ Mot de passe fort'; }
  });
}
</script>

</body>
</html>