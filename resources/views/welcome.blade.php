<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>BoutiqueConnect — Gérez votre commerce</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
  <style>
    :root{--gold:#F5B72E;--dark:#0A0A0A;--dark-2:#111;--dark-3:#1A1A1A;--gray:#888;--white:#FFF;--green:#22C55E;--radius:8px}
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    html{scroll-behavior:smooth}
    body{font-family:'DM Sans',sans-serif;background:var(--dark);color:var(--white);overflow-x:hidden}
    a{text-decoration:none}

    /* NAV */
    nav{position:fixed;top:0;left:0;right:0;z-index:100;display:flex;align-items:center;justify-content:space-between;padding:.875rem 3rem;background:rgba(10,10,10,.9);backdrop-filter:blur(20px);border-bottom:.5px solid rgba(255,255,255,.06)}
    .nav-logo{font-family:'Syne',sans-serif;font-weight:800;font-size:18px;color:var(--gold)}
    .nav-links{display:flex;gap:1.75rem;list-style:none}
    .nav-links a{color:rgba(255,255,255,.55);font-size:13px;font-weight:500;transition:color .2s}
    .nav-links a:hover{color:var(--white)}
    .nav-cta{display:flex;align-items:center;gap:.625rem}
    .btn-ghost{color:rgba(255,255,255,.65);background:transparent;border:.5px solid rgba(255,255,255,.15);border-radius:var(--radius);padding:7px 16px;font-size:12px;font-weight:500;font-family:'DM Sans',sans-serif;cursor:pointer}
    .btn-ghost:hover{border-color:rgba(255,255,255,.35);color:var(--white)}
    .btn-primary{background:var(--gold);color:var(--dark);border:none;border-radius:var(--radius);padding:8px 18px;font-size:12px;font-weight:700;font-family:'DM Sans',sans-serif;cursor:pointer;display:inline-flex;align-items:center;gap:5px;transition:all .2s}
    .btn-primary:hover{opacity:.85}

    /* HERO */
    .hero{min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:7rem 2rem 3rem;position:relative;overflow:hidden}
    .hero::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 70% 50% at 50% 0%,rgba(245,183,46,.1) 0%,transparent 70%);pointer-events:none}
    .hero-badge{display:inline-flex;align-items:center;gap:7px;background:rgba(245,183,46,.08);border:.5px solid rgba(245,183,46,.25);border-radius:50px;padding:5px 14px;font-size:11px;color:var(--gold);margin-bottom:1.5rem;font-weight:600;letter-spacing:.5px;text-transform:uppercase}
    .hero h1{font-family:'Syne',sans-serif;font-size:clamp(2rem,6vw,4.5rem);font-weight:800;line-height:1.08;max-width:800px;margin:0 auto 1.25rem}
    .hero h1 .accent{color:var(--gold)}
    .hero p{font-size:clamp(.9rem,1.5vw,1.05rem);color:rgba(255,255,255,.55);max-width:500px;margin:0 auto 2rem;line-height:1.65}
    .hero-btns{display:flex;gap:.875rem;justify-content:center;flex-wrap:wrap;margin-bottom:3rem}
    .btn-hero{background:var(--gold);color:var(--dark);border:none;border-radius:var(--radius);padding:12px 28px;font-size:14px;font-weight:700;font-family:'DM Sans',sans-serif;cursor:pointer;display:inline-flex;align-items:center;gap:7px;transition:all .2s}
    .btn-hero:hover{opacity:.85}
    .btn-hero-ghost{background:transparent;color:var(--white);border:.5px solid rgba(255,255,255,.18);border-radius:var(--radius);padding:12px 28px;font-size:14px;font-weight:500;font-family:'DM Sans',sans-serif;cursor:pointer;display:inline-flex;align-items:center;gap:7px}
    .hero-stats{display:flex;gap:2.5rem;justify-content:center;flex-wrap:wrap}
    .hero-stat strong{font-family:'Syne',sans-serif;font-size:1.75rem;font-weight:800;color:var(--gold);display:block}
    .hero-stat span{font-size:11px;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:.5px}

    /* SECTION */
    section{padding:5rem 3rem;max-width:1200px;margin:0 auto}
    .section-label{display:inline-block;font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--gold);margin-bottom:.875rem}
    h2.section-title{font-family:'Syne',sans-serif;font-weight:800;font-size:clamp(1.6rem,3.5vw,2.5rem);line-height:1.15;margin-bottom:.875rem}
    .section-sub{font-size:.95rem;color:rgba(255,255,255,.45);max-width:500px;line-height:1.65;margin-bottom:2.5rem}

    /* TARIFS */
    .pricing-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1.25rem;margin-top:2.5rem}
    .pricing-card{background:var(--dark-3);border:.5px solid rgba(255,255,255,.07);border-radius:10px;padding:1.5rem;position:relative;transition:border-color .2s}
    .pricing-card:hover{border-color:rgba(245,183,46,.25)}
    .pricing-card.popular{border-color:var(--gold)}
    .popular-badge{position:absolute;top:-11px;left:50%;transform:translateX(-50%);background:var(--gold);color:var(--dark);font-size:9px;font-weight:800;letter-spacing:1px;text-transform:uppercase;padding:3px 12px;border-radius:50px}
    .pricing-plan{font-size:11px;color:var(--gray);letter-spacing:1px;text-transform:uppercase;margin-bottom:.375rem;font-weight:600}
    .pricing-price{font-family:'Syne',sans-serif;font-weight:800;font-size:2.1rem;color:var(--white);margin-bottom:.2rem}
    .pricing-price span{font-size:12px;color:var(--gray);font-weight:400;font-family:'DM Sans',sans-serif}
    .pricing-desc{font-size:12px;color:rgba(255,255,255,.35);margin-bottom:1.25rem}
    .pricing-features{list-style:none;margin-bottom:1.5rem}
    .pricing-features li{display:flex;align-items:center;gap:7px;font-size:12px;color:rgba(255,255,255,.65);padding:.3rem 0;border-bottom:.5px solid rgba(255,255,255,.04)}
    .pricing-features li i{color:var(--green);font-size:13px}
    .btn-plan{width:100%;padding:10px;border-radius:var(--radius);font-size:12px;font-weight:700;font-family:'DM Sans',sans-serif;cursor:pointer;display:block;text-align:center;transition:all .2s}
    .btn-plan-gold{background:var(--gold);color:var(--dark);border:none}
    .btn-plan-gold:hover{opacity:.85}
    .btn-plan-outline{background:transparent;color:var(--white);border:.5px solid rgba(255,255,255,.18)}
    .btn-plan-outline:hover{border-color:rgba(255,255,255,.4)}

    /* CTA */
    .cta-section{text-align:center;padding:5rem 2rem;border-top:.5px solid rgba(255,255,255,.05)}
    .cta-section h2{font-family:'Syne',sans-serif;font-weight:800;font-size:clamp(1.75rem,4vw,3rem);margin-bottom:.875rem}
    .cta-section p{color:rgba(255,255,255,.45);font-size:.95rem;margin-bottom:2rem}

    /* FOOTER */
    footer{padding:2rem 3rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.875rem;border-top:.5px solid rgba(255,255,255,.05)}
    footer p{font-size:11px;color:rgba(255,255,255,.2)}
    .footer-links{display:flex;gap:1.25rem}
    .footer-links a{font-size:11px;color:rgba(255,255,255,.28)}
    .footer-links a:hover{color:var(--gold)}

    @media(max-width:768px){nav{padding:.875rem 1.25rem}.nav-links{display:none}section{padding:3.5rem 1.25rem}}
  </style>
</head>
<body>

<nav>
  <a href="/" class="nav-logo">⬡ BoutiqueConnect</a>
  <ul class="nav-links">
    <li><a href="#tarifs">Tarifs</a></li>
    <li><a href="#comment">Comment ça marche</a></li>
  </ul>
  <div class="nav-cta">
    <a href="/admin/login" class="btn-ghost">Se connecter</a>
    <a href="/inscription" class="btn-primary"><i class="ti ti-rocket"></i> Essai gratuit</a>
  </div>
</nav>

<div class="hero">
  <div class="hero-badge"><i class="ti ti-stars" style="font-size:13px"></i> 14 jours gratuits · Sans carte</div>
  <h1>Gérez votre boutique.<br>Vendez <span class="accent">partout en Afrique.</span></h1>
  <p>La plateforme tout-en-un pour les commerçants : caisse, stock, comptabilité, RH et boutique en ligne.</p>
  <div class="hero-btns">
    <a href="/inscription" class="btn-hero"><i class="ti ti-rocket"></i> Créer ma boutique — Gratuit</a>
    <a href="#tarifs" class="btn-hero-ghost"><i class="ti ti-tag"></i> Voir les tarifs</a>
  </div>
  <div class="hero-stats">
    <div class="hero-stat"><strong>500+</strong><span>boutiques</span></div>
    <div class="hero-stat"><strong>14j</strong><span>essai gratuit</span></div>
    <div class="hero-stat"><strong>99.9%</strong><span>disponibilité</span></div>
  </div>
</div>

<!-- TARIFS -->
<section id="tarifs" style="max-width:1200px;margin:0 auto;padding:5rem 3rem">
  <p class="section-label">Tarifs</p>
  <h2 class="section-title">Simple et transparent.</h2>
  <p class="section-sub">14 jours gratuits, aucune carte requise.</p>
  <div class="pricing-grid">
    @foreach($plans ?? [] as $plan)
    <div class="pricing-card {{ $plan->slug === 'pro' ? 'popular' : '' }}">
      @if($plan->slug === 'pro')<div class="popular-badge">⭐ POPULAIRE</div>@endif
      <div class="pricing-plan">{{ $plan->nom }}</div>
      <div class="pricing-price">{{ number_format($plan->prix_mensuel, 0, ',', ' ') }} <span>FCFA/mois</span></div>
      <p class="pricing-desc">{{ $plan->description }}</p>
      <a href="/inscription?plan={{ $plan->slug }}" class="btn-plan {{ $plan->slug === 'pro' ? 'btn-plan-gold' : 'btn-plan-outline' }}">
        Commencer gratuitement
      </a>
    </div>
    @endforeach
  </div>
</section>

<!-- CTA -->
<div class="cta-section">
  <h2>Prêt à digitaliser votre boutique ?</h2>
  <p>14 jours gratuits · Aucune carte bancaire · Annulable à tout moment</p>
  <a href="/inscription" class="btn-hero" style="display:inline-flex">
    <i class="ti ti-rocket"></i> Créer ma boutique — C'est gratuit
  </a>
</div>

<footer>
  <a href="/" style="font-family:'Syne',sans-serif;font-weight:800;font-size:16px;color:var(--gold)">⬡ BoutiqueConnect</a>
  <p>© {{ date('Y') }} BoutiqueConnect</p>
  <div class="footer-links">
    <a href="#">CGU</a>
    <a href="#">Contact</a>
    <a href="/admin/login">Espace marchand</a>
  </div>
</footer>

</body>
</html>