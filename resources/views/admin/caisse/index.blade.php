@extends('layouts.admin')
@section('title', 'Caisse')

@push('styles')
<style>
.pos-grid { display: grid; grid-template-columns: 1fr 420px; gap: 1.25rem; align-items: start; }
.prod-card {
    background: #fff;
    border: .5px solid #E5E5E0;
    border-radius: 8px;
    padding: .875rem;
    cursor: pointer;
    transition: all .15s;
    text-align: center;
    user-select: none;
}
.prod-card:hover  { border-color: var(--primary); box-shadow: 0 2px 12px rgba(0,0,0,.08); transform: translateY(-1px); }
.prod-card:active { transform: scale(.97); }
.prod-card.rupture { opacity: .45; cursor: not-allowed; }
.cart-item-row { display:flex;align-items:center;gap:.5rem;padding:.625rem 1rem;border-bottom:.5px solid #F7F7F5; }
.qty-btn { width:24px;height:24px;border:.5px solid #DDD;border-radius:4px;background:#fff;cursor:pointer;font-size:14px;display:flex;align-items:center;justify-content:center;transition:background .1s; }
.qty-btn:hover { background:#F5F5F0; }
.mode-btn { flex:1;padding:9px 4px;border:.5px solid #DDD;border-radius:6px;background:#fff;cursor:pointer;font-size:11px;text-align:center;transition:all .15s;font-family:inherit; }
.mode-btn.active { background:var(--dark);color:#fff;border-color:var(--dark); }
.notif-pop { position:fixed;bottom:24px;right:24px;background:#1A1A1A;color:#fff;border-radius:8px;padding:10px 18px;font-size:13px;font-weight:600;z-index:999;animation:popIn .2s ease; }
.notif-pop.warn { background:#F59E0B;color:#1A1A1A; }
@keyframes popIn { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }
.session-stat { background:#fff;border:.5px solid #E5E5E0;border-radius:8px;padding:.875rem 1rem;display:flex;align-items:center;gap:.75rem; }
.session-stat .ico { width:38px;height:38px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0; }
.session-stat .lbl { font-size:11px;color:#888;margin-bottom:2px; }
.session-stat .val { font-family:'Syne',sans-serif;font-weight:800;font-size:1rem; }
.caisse-actions { display:flex;gap:.625rem;margin-bottom:1rem;flex-wrap:wrap; }
.tab-btn { padding:7px 14px;border:.5px solid #DDD;border-radius:6px;background:#fff;cursor:pointer;font-size:12px;font-weight:600;font-family:inherit;transition:all .15s; }
.tab-btn.active { background:var(--dark);color:#fff;border-color:var(--dark); }
.modal-backdrop { display:none;position:fixed;inset:0;background:rgba(0,0,0,.55);z-index:200;align-items:center;justify-content:center; }
.modal-box { background:#fff;border-radius:14px;padding:1.75rem;max-width:400px;width:95%; }
.numpad-grid { display:grid;grid-template-columns:repeat(3,1fr);gap:6px;margin:10px 0; }
.nk { padding:13px;border:.5px solid #DDD;border-radius:6px;background:#F9F9F6;cursor:pointer;font-size:15px;font-weight:700;font-family:'Syne',sans-serif;text-align:center;transition:background .1s; }
.nk:hover { background:#EEEEE8; }
.amount-disp { font-family:'Syne',sans-serif;font-size:1.75rem;font-weight:800;text-align:center;padding:12px;background:#F5F5F0;border-radius:8px;margin-bottom:8px;letter-spacing:1px; }
.change-ok { background:#DCFCE7;color:#166534;border-radius:6px;padding:9px;text-align:center;font-size:13px;font-weight:700;margin-bottom:12px; }
</style>
@endpush

@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif
@if($errors->any())
<div class="alert-ko"><i class="ti ti-alert-circle"></i> {{ $errors->first() }}</div>
@endif

@if($session)
{{-- ═══════════════════════════════ SESSION OUVERTE ═══════════════════════════════ --}}

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;flex-wrap:wrap;gap:.5rem">
    <div style="display:flex;align-items:center;gap:.75rem">
        <h1 style="font-family:'Syne',sans-serif;font-size:1.3rem;font-weight:800">Caisse</h1>
        <span class="badge badge-success"><i class="ti ti-circle"></i> Session ouverte</span>
        <span style="font-size:12px;color:#888">depuis {{ $session->ouverture_at->format('d/m/Y à H:i') }} · {{ session('admin_login') }}</span>
    </div>
    <div style="display:flex;gap:.5rem">
        <a href="{{ route('admin.caisse.historique') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD">
            <i class="ti ti-history"></i> Historique
        </a>
        <button onclick="toggleFermerModal()" class="btn btn-sm btn-red">
            <i class="ti ti-lock"></i> Fermer la caisse
        </button>
    </div>
</div>

{{-- Stats en temps réel --}}
<div id="stats-bar" style="display:grid;grid-template-columns:repeat(4,1fr);gap:.75rem;margin-bottom:1.25rem">
    <div class="session-stat">
        <div class="ico" style="background:#F0FDF4;color:#22C55E"><i class="ti ti-coins"></i></div>
        <div><div class="lbl">Espèces</div><div class="val" id="stat-especes">{{ number_format($session->total_especes,0,',',' ') }} <small style="font-size:11px;font-weight:400">{{ session('boutique.devise','FCFA') }}</small></div></div>
    </div>
    <div class="session-stat">
        <div class="ico" style="background:#EFF6FF;color:#3B82F6"><i class="ti ti-credit-card"></i></div>
        <div><div class="lbl">Carte</div><div class="val" id="stat-carte">{{ number_format($session->total_carte,0,',',' ') }} <small style="font-size:11px;font-weight:400">{{ session('boutique.devise','FCFA') }}</small></div></div>
    </div>
    <div class="session-stat">
        <div class="ico" style="background:#FFFBEB;color:#F59E0B"><i class="ti ti-device-mobile"></i></div>
        <div><div class="lbl">Mobile</div><div class="val" id="stat-mobile">{{ number_format($session->total_mobile,0,',',' ') }} <small style="font-size:11px;font-weight:400">{{ session('boutique.devise','FCFA') }}</small></div></div>
    </div>
    <div class="session-stat">
        <div class="ico" style="background:#FFF7ED;color:#EA580C"><i class="ti ti-chart-bar"></i></div>
        <div><div class="lbl">Total ventes</div><div class="val" id="stat-total" style="color:var(--primary)">{{ number_format($session->total_ventes,0,',',' ') }} <small style="font-size:11px;font-weight:400">{{ session('boutique.devise','FCFA') }}</small></div></div>
    </div>
</div>

{{-- POS --}}
<div class="pos-grid">

    {{-- GAUCHE : Catalogue --}}
    <div>
        <div style="display:flex;gap:.625rem;margin-bottom:.875rem;flex-wrap:wrap">
            <input type="text" id="search-produit" placeholder="Rechercher un produit..."
                   oninput="filterProduits(this.value)"
                   style="flex:1;min-width:180px;border:.5px solid #DDD;border-radius:6px;padding:8px 13px;font-size:13px;font-family:inherit;outline:none">
            <select id="filter-cat" onchange="filterProduits(document.getElementById('search-produit').value)"
                    style="border:.5px solid #DDD;border-radius:6px;padding:8px 13px;font-size:13px;font-family:inherit;outline:none">
                <option value="">Toutes catégories</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                @endforeach
            </select>
        </div>

        <div id="produits-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:.625rem;overflow-y:auto;max-height:calc(100vh - 200px);padding-right:4px">
            @foreach($produits as $p)
            @php $stock = $p->stock?->quantite ?? 0; @endphp
            <div class="prod-card {{ $stock <= 0 ? 'rupture' : '' }}"
                 data-id="{{ $p->id }}"
                 data-nom="{{ addslashes($p->nom) }}"
                 data-prix="{{ $p->prix_final }}"
                 data-stock="{{ $stock }}"
                 data-cat="{{ $p->categorie_id }}"
                 onclick="{{ $stock > 0 ? 'ajouterPanier(this)' : 'notif(\'Stock épuisé\',\'warn\')' }}">
                <div style="font-size:1.75rem;margin-bottom:6px">
                    <i class="ti {{ $p->icone ?? 'ti-package' }}" style="color:var(--primary)"></i>
                </div>
                <div style="font-size:11px;font-weight:700;line-height:1.3;margin-bottom:4px">{{ Str::limit($p->nom, 22) }}</div>
                <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:13px;color:var(--primary)">
                    {{ number_format($p->prix_final, 0, ',', ' ') }}
                </div>
                <div class="prod-stock-lbl" style="font-size:10px;color:{{ $stock <= 3 ? '#EF4444' : '#AAA' }};margin-top:3px">
                    @if($stock <= 0) Rupture @elseif($stock <= 5) ⚠ {{ $stock }} restants @else {{ $stock }} en stock @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- DROITE : Panier + Paiement --}}
    <div style="position:sticky;top:72px;height:calc(100vh - 200px);display:flex;flex-direction:column">
        <div class="card" style="padding:0;overflow:hidden;display:flex;flex-direction:column;height:100%">

            {{-- Header panier --}}
            <div style="background:var(--dark);color:#fff;padding:.875rem 1.1rem;font-family:'Syne',sans-serif;font-weight:700;font-size:13px;display:flex;align-items:center;justify-content:space-between">
                <span><i class="ti ti-shopping-cart"></i> Commande <span id="order-ref">#{{ str_pad($session->ventes_count + 1 ?? 1, 3, '0', STR_PAD_LEFT) }}</span></span>
                <div style="display:flex;align-items:center;gap:.5rem">
                    <span id="cart-count-badge" style="background:rgba(255,255,255,.15);padding:2px 8px;border-radius:20px;font-size:11px">0 art.</span>
                    <button onclick="viderPanier()" style="background:rgba(255,255,255,.1);border:none;color:rgba(255,255,255,.6);padding:3px 9px;border-radius:4px;cursor:pointer;font-size:11px;font-family:inherit">Vider</button>
                </div>
            </div>

            {{-- Items panier --}}
            <div id="panier-vide" style="padding:1.5rem;text-align:center;color:#bbb;font-size:13px;border-bottom:.5px solid #F0F0EB;flex-shrink:0">
                <i class="ti ti-shopping-cart-off" style="font-size:2rem;display:block;margin-bottom:.5rem"></i>
                Sélectionnez un produit dans le catalogue
            </div>
            <div id="panier-items" style="overflow-y:auto;flex:1;min-height:0"></div>

            <div style="padding:.875rem 1.1rem;border-top:.5px solid #F0F0EB;flex-shrink:0;overflow-y:auto;max-height:320px">

                {{-- Client --}}
                <div class="fg" style="margin-bottom:.625rem">
                    <label>Client</label>
                    <select id="client-select" style="width:100%">
                        <option value="">— Anonyme —</option>
                        @foreach($clients as $cl)
                        <option value="{{ $cl->id }}">{{ $cl->prenom }} {{ $cl->nom }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Remise --}}
                <div style="display:flex;gap:.5rem;margin-bottom:.625rem">
                    <div class="fg" style="flex:1;margin:0">
                        <label>Remise %</label>
                        <input type="number" id="remise-input" min="0" max="100" step="1" value="0"
                               oninput="calculerTotal()" style="width:100%">
                    </div>
                    <div class="fg" style="flex:1;margin:0">
                        <label>Remise fixe ({{ session('boutique.devise','FCFA') }})</label>
                        <input type="number" id="remise-fixe-input" min="0" step="100" value="0"
                               oninput="calculerTotal()" style="width:100%">
                    </div>
                </div>

                {{-- Mode de paiement --}}
                <label style="font-size:12px;color:#666;font-weight:600;display:block;margin-bottom:6px">Mode de paiement</label>
                <div style="display:flex;gap:6px;margin-bottom:.875rem">
                    <button class="mode-btn active" id="mode-sur_place"     onclick="setMode('sur_place')"><i class="ti ti-cash" style="font-size:16px;display:block;margin:0 auto 2px"></i>Espèces</button>
                    <button class="mode-btn"         id="mode-carte"         onclick="setMode('carte')"><i class="ti ti-credit-card" style="font-size:16px;display:block;margin:0 auto 2px"></i>Carte</button>
                    <button class="mode-btn"         id="mode-orange_money"  onclick="setMode('orange_money')"><i class="ti ti-device-mobile" style="font-size:16px;display:block;margin:0 auto 2px"></i>Orange</button>
                    <button class="mode-btn"         id="mode-wero"          onclick="setMode('wero')"><i class="ti ti-device-mobile" style="font-size:16px;display:block;margin:0 auto 2px"></i>Wero</button>
                    <button class="mode-btn"         id="mode-credit"        onclick="setMode('credit')"><i class="ti ti-clock" style="font-size:16px;display:block;margin:0 auto 2px"></i>Crédit</button>
                </div>

                {{-- Acompte si crédit --}}
                <div id="credit-zone" style="display:none;margin-bottom:.625rem">
                    <div style="display:flex;gap:.5rem">
                        <div class="fg" style="flex:1;margin:0">
                            <label>Acompte</label>
                            <input type="number" id="acompte-input" min="0" step="100" value="0" style="width:100%">
                        </div>
                        <div class="fg" style="flex:1;margin:0">
                            <label>Échéance</label>
                            <input type="date" id="echeance-input" style="width:100%">
                        </div>
                    </div>
                </div>

                {{-- Totaux --}}
                <div style="background:#F9F9F6;border-radius:6px;padding:.625rem .75rem;margin-bottom:.75rem;font-size:13px">
                    <div style="display:flex;justify-content:space-between;color:#888;padding:2px 0"><span>Sous-total HT</span><span id="disp-ht">0</span></div>
                    <div id="row-remise" style="display:flex;justify-content:space-between;color:#22C55E;padding:2px 0;display:none"><span>Remise</span><span id="disp-remise">—</span></div>
                    <div style="display:flex;justify-content:space-between;color:#888;padding:2px 0"><span>TVA ({{ $tva_taux ?? 18 }}%)</span><span id="disp-tva">0</span></div>
                    <div style="display:flex;justify-content:space-between;font-family:'Syne',sans-serif;font-weight:800;font-size:1rem;padding-top:6px;border-top:.5px solid #E5E5E0;margin-top:4px">
                        <span>Total TTC</span>
                        <span id="disp-total" style="color:var(--primary)">0 {{ session('boutique.devise','FCFA') }}</span>
                    </div>
                </div>

                {{-- Bouton valider --}}
                <button onclick="ouvrirPaiement()" id="btn-valider" disabled
                        style="width:100%;background:var(--primary);color:#1A1A1A;border:none;border-radius:8px;padding:13px;font-size:14px;font-weight:800;cursor:pointer;font-family:inherit;display:flex;align-items:center;justify-content:center;gap:8px;transition:opacity .15s;opacity:.4">
                    <i class="ti ti-check" style="font-size:18px"></i> Encaisser
                </button>

                {{-- Notes --}}
                <input type="text" id="notes-input" placeholder="Note (optionnel)..."
                       style="width:100%;margin-top:.5rem;border:.5px solid #DDD;border-radius:6px;padding:7px 11px;font-size:12px;font-family:inherit;outline:none;box-sizing:border-box">
            </div>
        </div>
    </div>
</div>

{{-- ═══ MODAL PAIEMENT ESPÈCES ═══ --}}
<div class="modal-backdrop" id="modal-especes" style="display:none;position:fixed">
    <div class="modal-box" style="width:420px">
        <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem">
            <div style="width:38px;height:38px;background:#F0FDF4;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#22C55E;font-size:20px;flex-shrink:0">
                <i class="ti ti-cash"></i>
            </div>
            <div>
                <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:1rem">Paiement espèces</div>
                <div style="font-size:12px;color:#888">Total à encaisser : <strong id="me-montant" style="color:var(--dark)"></strong></div>
            </div>
        </div>

        {{-- Montant remis --}}
        <div style="margin-bottom:.875rem">
            <label style="font-size:11px;font-weight:600;color:#888;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:6px">
                Montant remis par le client
            </label>
            <div class="amount-disp" id="me-display" style="font-size:2rem;cursor:text">0</div>
        </div>

        {{-- Numpad --}}
        <div class="numpad-grid" style="margin-bottom:.75rem">
            <button class="nk" onclick="nk('1')">1</button>
            <button class="nk" onclick="nk('2')">2</button>
            <button class="nk" onclick="nk('3')">3</button>
            <button class="nk" onclick="nk('4')">4</button>
            <button class="nk" onclick="nk('5')">5</button>
            <button class="nk" onclick="nk('6')">6</button>
            <button class="nk" onclick="nk('7')">7</button>
            <button class="nk" onclick="nk('8')">8</button>
            <button class="nk" onclick="nk('9')">9</button>
            <button class="nk" onclick="nk('⌫')" style="font-size:20px;color:#EF4444">⌫</button>
            <button class="nk" onclick="nk('0')">0</button>
            <button class="nk" onclick="nk('00')">00</button>
        </div>

        {{-- Raccourcis billets --}}
        <div style="display:flex;gap:5px;margin-bottom:.875rem" id="quick-btns"></div>

        {{-- Zone monnaie --}}
        <div id="me-monnaie" style="min-height:44px;margin-bottom:.875rem"></div>

        {{-- Actions --}}
        <div style="display:flex;gap:.5rem">
            <button onclick="fermerModal('modal-especes')" class="btn"
                    style="flex:1;background:#F5F5F0;border:.5px solid #DDD;color:#666">
                Annuler
            </button>
            <button onclick="confirmerVente()" id="me-confirm" disabled class="btn"
                    style="flex:2;background:var(--primary);border:none;color:#1A1A1A;font-weight:700;opacity:.4;font-size:14px">
                <i class="ti ti-check"></i> Valider l'encaissement
            </button>
        </div>
    </div>
</div>

{{-- ═══ MODAL CARTE / MOBILE ═══ --}}
<div class="modal-backdrop" id="modal-simple" style="display:none;position:fixed">
    <div class="modal-box" style="text-align:center">
        <div id="ms-icon" style="width:64px;height:64px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-size:2rem"></div>
        <h3 id="ms-titre" style="font-family:'Syne',sans-serif;font-weight:800;margin-bottom:.5rem"></h3>
        <p id="ms-montant" style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.5rem;color:var(--primary);margin-bottom:.5rem"></p>
        <p id="ms-info" style="font-size:13px;color:#888;margin-bottom:1.5rem"></p>
        <div id="ms-ussd" style="display:none;margin-bottom:1rem;padding:10px;background:#F5F5F0;border-radius:6px;font-size:14px;font-weight:700"></div>
        <div style="display:flex;gap:.5rem">
            <button onclick="fermerModal('modal-simple')" class="btn" style="flex:1;background:#F5F5F0;border:.5px solid #DDD;color:#666">Annuler</button>
            <button onclick="confirmerVente()" class="btn" style="flex:1;background:var(--primary);border:none;color:#1A1A1A">Confirmer réception</button>
        </div>
    </div>
</div>

{{-- ═══ MODAL CRÉDIT ═══ --}}
<div class="modal-backdrop" id="modal-credit" style="display:none;position:fixed">
    <div class="modal-box">
        <h3 style="font-family:'Syne',sans-serif;font-weight:800;margin-bottom:1rem"><i class="ti ti-clock"></i> Vente à crédit</h3>
        <div id="mc-detail" style="font-size:13px;color:#888;margin-bottom:1rem"></div>
        <div style="display:flex;gap:.5rem">
            <button onclick="fermerModal('modal-credit')" class="btn" style="flex:1;background:#F5F5F0;border:.5px solid #DDD;color:#666">Annuler</button>
            <button onclick="confirmerVente()" class="btn" style="flex:1;background:var(--primary);border:none;color:#1A1A1A">Confirmer</button>
        </div>
    </div>
</div>

{{-- ═══ MODAL REÇU ═══ --}}
<div class="modal-backdrop" id="modal-recu" style="display:none;position:fixed">
    <div style="background:#fff;border-radius:14px;width:480px;max-width:96vw;max-height:90vh;overflow-y:auto;box-shadow:0 20px 60px rgba(0,0,0,.2)">

        {{-- En-tête succès --}}
        <div style="background:var(--dark);color:#fff;padding:1.25rem 1.5rem;border-radius:14px 14px 0 0;display:flex;align-items:center;gap:.75rem">
            <div style="width:36px;height:36px;background:#22C55E;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0">
                <i class="ti ti-check"></i>
            </div>
            <div>
                <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:1rem">Vente enregistrée !</div>
                <div id="recu-ref-header" style="font-size:12px;opacity:.6"></div>
            </div>
            <button onclick="fermerModal('modal-recu')" style="margin-left:auto;background:rgba(255,255,255,.1);border:none;color:#fff;width:28px;height:28px;border-radius:50%;cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center">×</button>
        </div>

        {{-- Corps facture --}}
        <div id="recu-body" style="padding:1.5rem"></div>

        {{-- Actions --}}
        <div style="padding:1rem 1.5rem 1.5rem;display:flex;gap:.625rem;border-top:.5px solid #F0F0EB">
            <button onclick="imprimerRecu()" class="btn" style="flex:1;background:#F5F5F0;border:.5px solid #DDD;color:#666;font-size:13px">
                <i class="ti ti-printer"></i> Imprimer
            </button>
            <button onclick="nouvelleVente()" class="btn" style="flex:1;background:var(--primary);border:none;color:#1A1A1A;font-size:13px;font-weight:700">
                <i class="ti ti-plus"></i> Nouvelle vente
            </button>
        </div>
    </div>
</div>

{{-- ═══ MODAL FERMETURE ═══ --}}
<div class="modal-backdrop" id="modal-fermer" style="display:none;position:fixed">
    <div class="modal-box">
        <h3 style="font-family:'Syne',sans-serif;font-weight:800;margin-bottom:1rem;color:#DC2626"><i class="ti ti-lock"></i> Fermer la caisse</h3>
        <div style="background:#FEF2F2;border:.5px solid #FECACA;border-radius:6px;padding:.75rem;font-size:13px;color:#DC2626;margin-bottom:1rem">
            Cette action clôture la session. Les totaux seront calculés automatiquement.
        </div>
        <form method="POST" action="{{ route('admin.caisse.fermer') }}">
            @csrf
            <div class="fg" style="margin-bottom:.75rem">
                <label>Fond de caisse à la fermeture</label>
                <input type="number" name="fond_fermeture" min="0" step="0.01" placeholder="Montant en caisse" style="width:100%">
            </div>
            <div class="fg" style="margin-bottom:1rem">
                <label>Notes de clôture</label>
                <input type="text" name="notes" placeholder="Observations..." style="width:100%">
            </div>
            <div style="display:flex;gap:.5rem">
                <button type="button" onclick="fermerModal('modal-fermer')" class="btn" style="flex:1;background:#F5F5F0;border:.5px solid #DDD;color:#666">Annuler</button>
                <button type="submit" class="btn btn-red" style="flex:1">Confirmer la fermeture</button>
            </div>
        </form>
    </div>
</div>

@else
{{-- ═══════════════════════════════ PAS DE SESSION ═══════════════════════════════ --}}

<div class="page-header">
    <h1>Caisse</h1>
    <a href="{{ route('admin.caisse.historique') }}" class="btn btn-sm" style="background:#F5F5F0;color:#666;border:.5px solid #DDD">
        <i class="ti ti-history"></i> Historique
    </a>
</div>

<div class="card" style="padding:2.5rem;text-align:center;max-width:420px;margin:0 auto">
    <i class="ti ti-cash-register" style="font-size:3.5rem;color:#DDD;display:block;margin-bottom:1rem"></i>
    <h2 style="font-family:'Syne',sans-serif;font-weight:800;margin-bottom:.5rem">Aucune session ouverte</h2>
    <p style="color:#888;font-size:14px;margin-bottom:2rem">Ouvrez la caisse pour commencer à enregistrer des ventes.</p>
    <form method="POST" action="{{ route('admin.caisse.ouvrir') }}">
        @csrf
        <div class="fg" style="text-align:left;margin-bottom:1rem">
            <label>Fond de caisse initial ({{ session('boutique.devise','FCFA') }})</label>
            <input type="number" name="fond_ouverture" min="0" step="100" required placeholder="ex: 50 000">
        </div>
        <button type="submit" class="btn btn-gold" style="width:100%;justify-content:center">
            <i class="ti ti-lock-open"></i> Ouvrir la caisse
        </button>
    </form>
</div>
@endif

@endsection

@if($session)
@push('scripts')
<script>
const CSRF   = '{{ csrf_token() }}';
const DEVISE = '{{ session('boutique.devise','FCFA') }}';
const TVA    = {{ ($tva_taux ?? 18) / 100 }};
const VENDRE_URL = '{{ route('admin.ventes.vendre') }}';

let panier = [], modeP = 'sur_place', cashStr = '';
let lastVente = null;

// ── Panier ──────────────────────────────────────────────
function ajouterPanier(el) {
    const id    = parseInt(el.dataset.id);
    const nom   = el.dataset.nom;
    const prix  = parseFloat(el.dataset.prix);
    const stock = parseInt(el.dataset.stock);
    const ex    = panier.find(p => p.id === id);
    if (ex) {
        if (ex.quantite < stock) ex.quantite++;
        else { notif('Stock insuffisant', 'warn'); return; }
    } else {
        panier.push({ id, nom, prix, quantite: 1, stock });
    }
    el.style.transform = 'scale(.95)';
    setTimeout(() => el.style.transform = '', 150);
    renderPanier();
    notif(nom + ' ajouté');
}

function changeQte(id, d) {
    const p = panier.find(x => x.id === id);
    if (!p) return;
    p.quantite += d;
    if (p.quantite <= 0) {
        panier = panier.filter(x => x.id !== id);
        renderPanier(); // re-render complet pour supprimer la ligne
    } else {
        if (p.quantite > p.stock) { p.quantite = p.stock; notif('Stock max atteint', 'warn'); }
        updateLigne(id); // mise à jour douce juste de cette ligne
    }
}
function retirerPanier(id) { panier = panier.filter(p => p.id !== id); renderPanier(); }
function viderPanier()     { panier = []; renderPanier(); }

function renderPanier() {
    const wrap = document.getElementById('panier-items');
    const vide = document.getElementById('panier-vide');
    const cnt  = document.getElementById('cart-count-badge');
    const totalQte = panier.reduce((s, p) => s + p.quantite, 0);
    cnt.textContent = totalQte + ' art.';

    if (!panier.length) {
        wrap.innerHTML = '';
        wrap.style.display = 'none';
        vide.style.display = 'block';
        calculerTotal();
        return;
    }

    vide.style.display = 'none';
    wrap.style.display = 'block';

    wrap.innerHTML = `
        <table style="width:100%;border-collapse:collapse">
            <thead>
                <tr style="background:#F5F5F0;border-bottom:.5px solid #E5E5E0">
                    <th style="padding:7px 12px;text-align:left;font-size:11px;font-weight:600;color:#888;text-transform:uppercase;letter-spacing:.5px">Article</th>
                    <th style="padding:7px 8px;text-align:center;font-size:11px;font-weight:600;color:#888;text-transform:uppercase;letter-spacing:.5px;width:110px">Quantité</th>
                    <th style="padding:7px 12px;text-align:right;font-size:11px;font-weight:600;color:#888;text-transform:uppercase;letter-spacing:.5px;width:90px">Total</th>
                </tr>
            </thead>
            <tbody>
                ${panier.map((p, i) => `
                <tr id="row-${p.id}" style="border-bottom:.5px solid #F5F5F0;background:${i % 2 === 0 ? '#fff' : '#FAFAF8'};transition:background .15s">
                    <td style="padding:8px 12px">
                        <div style="font-size:13px;font-weight:700;color:var(--dark);line-height:1.3">${p.nom}</div>
                        <div style="font-size:11px;color:#aaa;margin-top:2px">${p.prix.toLocaleString('fr-FR')} / u</div>
                    </td>
                    <td style="padding:6px 8px;text-align:center">
                        <div style="display:inline-flex;align-items:center;gap:5px;background:#F5F5F0;border-radius:8px;padding:3px 5px;border:.5px solid #E5E5E0">
                            <button onclick="changeQte(${p.id},-1)"
                                style="width:26px;height:26px;border:none;border-radius:6px;background:#fff;cursor:pointer;font-size:15px;font-weight:700;color:#666;display:flex;align-items:center;justify-content:center;box-shadow:0 1px 3px rgba(0,0,0,.08);transition:all .1s"
                                onmouseover="this.style.background='#EEE'" onmouseout="this.style.background='#fff'">−</button>
                            <span id="qty-${p.id}" style="font-size:14px;font-weight:800;min-width:24px;text-align:center;color:var(--dark)">${p.quantite}</span>
                            <button onclick="changeQte(${p.id},1)"
                                style="width:26px;height:26px;border:none;border-radius:6px;background:var(--primary);cursor:pointer;font-size:15px;font-weight:700;color:#1A1A1A;display:flex;align-items:center;justify-content:center;box-shadow:0 1px 3px rgba(0,0,0,.12);transition:all .1s"
                                onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'">+</button>
                        </div>
                    </td>
                    <td style="padding:8px 12px;text-align:right">
                        <div id="total-${p.id}" style="font-family:'Syne',sans-serif;font-weight:800;font-size:13px;color:var(--primary)">${(p.prix * p.quantite).toLocaleString('fr-FR')}</div>
                        <button onclick="retirerPanier(${p.id})"
                            style="font-size:10px;color:#CCC;border:none;background:none;cursor:pointer;padding:0;margin-top:2px;text-decoration:underline"
                            onmouseover="this.style.color='#EF4444'" onmouseout="this.style.color='#CCC'">suppr.</button>
                    </td>
                </tr>`).join('')}
            </tbody>
        </table>`;

    calculerTotal();
}

// Mise à jour douce d'une ligne sans re-render complet
function updateLigne(id) {
    const p = panier.find(x => x.id === id);
    if (!p) return;
    const qtyEl   = document.getElementById('qty-' + id);
    const totalEl = document.getElementById('total-' + id);
    const rowEl   = document.getElementById('row-' + id);
    if (qtyEl)   qtyEl.textContent   = p.quantite;
    if (totalEl) totalEl.textContent = (p.prix * p.quantite).toLocaleString('fr-FR');
    if (rowEl) {
        rowEl.style.background = '#FFFBEB';
        setTimeout(() => { if (rowEl) rowEl.style.background = ''; }, 300);
    }
    calculerTotal();
}

function calculerTotal() {
    const ht0   = panier.reduce((s, p) => s + p.prix * p.quantite, 0);
    const rPct  = parseFloat(document.getElementById('remise-input').value) || 0;
    const rFix  = parseFloat(document.getElementById('remise-fixe-input').value) || 0;
    const remise= Math.min(ht0 * rPct / 100 + rFix, ht0);
    const ht    = ht0 - remise;
    const tva   = Math.round(ht * TVA);
    const ttc   = ht + tva;

    document.getElementById('disp-ht').textContent    = ht0.toLocaleString('fr-FR') + ' ' + DEVISE;
    document.getElementById('disp-tva').textContent   = tva.toLocaleString('fr-FR') + ' ' + DEVISE;
    document.getElementById('disp-total').textContent = ttc.toLocaleString('fr-FR') + ' ' + DEVISE;

    const rowR = document.getElementById('row-remise');
    if (remise > 0) {
        rowR.style.display = 'flex';
        document.getElementById('disp-remise').textContent = '-' + remise.toLocaleString('fr-FR') + ' ' + DEVISE;
    } else {
        rowR.style.display = 'none';
    }

    const btn = document.getElementById('btn-valider');
    if (panier.length > 0) {
        btn.disabled = false;
        btn.style.opacity = '1';
        btn.innerHTML = `<i class="ti ti-check" style="font-size:18px"></i> Encaisser — ${ttc.toLocaleString('fr-FR')} ${DEVISE}`;
    } else {
        btn.disabled = true;
        btn.style.opacity = '.4';
        btn.innerHTML = `<i class="ti ti-check" style="font-size:18px"></i> Encaisser`;
    }
}

function getTTC() {
    const ht0   = panier.reduce((s, p) => s + p.prix * p.quantite, 0);
    const rPct  = parseFloat(document.getElementById('remise-input').value) || 0;
    const rFix  = parseFloat(document.getElementById('remise-fixe-input').value) || 0;
    const remise= Math.min(ht0 * rPct / 100 + rFix, ht0);
    const ht    = ht0 - remise;
    return ht + Math.round(ht * TVA);
}

// ── Mode paiement ──────────────────────────────────────
function setMode(m) {
    modeP = m;
    ['sur_place','carte','orange_money','wero','credit'].forEach(x => {
        const el = document.getElementById('mode-' + x);
        if (el) el.classList.toggle('active', x === m);
    });
    document.getElementById('credit-zone').style.display = m === 'credit' ? 'block' : 'none';
}

// ── Ouverture modal paiement ───────────────────────────
function ouvrirPaiement() {
    if (!panier.length) return;
    const ttc = getTTC();
    if (modeP === 'sur_place') {
        cashStr = '';
        document.getElementById('me-montant').textContent = ttc.toLocaleString('fr-FR') + ' ' + DEVISE;
        document.getElementById('me-confirm').disabled = true;
        document.getElementById('me-confirm').style.opacity = '.4';
        document.getElementById('me-confirm').innerHTML = '<i class="ti ti-check"></i> Valider l\'encaissement';

        // Raccourcis : montant exact + billets supérieurs courants FCFA
        const qb = document.getElementById('quick-btns');
        const billets = [500,1000,2000,5000,10000,20000,50000,100000,200000,500000];
        // On prend le montant exact + les 3 billets immédiatement supérieurs
        const superieurs = billets.filter(b => b > ttc).slice(0, 3);
        const suggestions = [ttc, ...superieurs];
        qb.innerHTML = suggestions.map(v =>
            `<button onclick="setCash(${v})" class="btn"
                style="flex:1;background:${v===ttc?'var(--dark)':'#F5F5F0'};border:.5px solid #DDD;
                       color:${v===ttc?'#fff':'#1A1A1A'};font-size:11px;font-weight:700;padding:7px 4px;
                       border-radius:6px;text-align:center;line-height:1.3">
                <span style="display:block;font-size:10px;opacity:.6">${v===ttc?'Exact':'Billet'}</span>
                ${v.toLocaleString('fr-FR')}
            </button>`
        ).join('');

        majCash();
        ouvrirModal('modal-especes');
    } else if (modeP === 'carte') {
        document.getElementById('ms-icon').style.background = '#EFF6FF';
        document.getElementById('ms-icon').style.color = '#3B82F6';
        document.getElementById('ms-icon').innerHTML = '<i class="ti ti-credit-card"></i>';
        document.getElementById('ms-titre').textContent = 'Paiement carte';
        document.getElementById('ms-montant').textContent = ttc.toLocaleString('fr-FR') + ' ' + DEVISE;
        document.getElementById('ms-info').textContent = 'Présentez votre carte sur le terminal TPE.';
        document.getElementById('ms-ussd').style.display = 'none';
        ouvrirModal('modal-simple');
    } else if (modeP === 'orange_money') {
        document.getElementById('ms-icon').style.background = '#FFF7ED';
        document.getElementById('ms-icon').style.color = '#EA580C';
        document.getElementById('ms-icon').innerHTML = '<i class="ti ti-device-mobile"></i>';
        document.getElementById('ms-titre').textContent = 'Orange Money';
        document.getElementById('ms-montant').textContent = ttc.toLocaleString('fr-FR') + ' ' + DEVISE;
        document.getElementById('ms-info').textContent = 'Demandez au client de composer le code USSD ou scannez le QR.';
        document.getElementById('ms-ussd').style.display = 'block';
        document.getElementById('ms-ussd').textContent = '#144*7*' + ttc + '#';
        ouvrirModal('modal-simple');
    } else if (modeP === 'wero') {
        document.getElementById('ms-icon').style.background = '#F5F3FF';
        document.getElementById('ms-icon').style.color = '#7C3AED';
        document.getElementById('ms-icon').innerHTML = '<i class="ti ti-device-mobile"></i>';
        document.getElementById('ms-titre').textContent = 'Wero';
        document.getElementById('ms-montant').textContent = ttc.toLocaleString('fr-FR') + ' ' + DEVISE;
        document.getElementById('ms-info').textContent = 'Confirmez la réception du paiement Wero.';
        document.getElementById('ms-ussd').style.display = 'none';
        ouvrirModal('modal-simple');
    } else if (modeP === 'credit') {
        const acompte = parseFloat(document.getElementById('acompte-input').value) || 0;
        const restant = ttc - acompte;
        const echeance = document.getElementById('echeance-input').value;
        document.getElementById('mc-detail').innerHTML = `
            <div style="display:flex;justify-content:space-between;margin-bottom:4px"><span>Total :</span><strong>${ttc.toLocaleString('fr-FR')} ${DEVISE}</strong></div>
            <div style="display:flex;justify-content:space-between;margin-bottom:4px"><span>Acompte :</span><span style="color:#22C55E">${acompte.toLocaleString('fr-FR')} ${DEVISE}</span></div>
            <div style="display:flex;justify-content:space-between;color:#DC2626"><span>Reste à payer :</span><strong>${restant.toLocaleString('fr-FR')} ${DEVISE}</strong></div>
            ${echeance ? `<div style="margin-top:4px;color:#888;font-size:12px">Échéance : ${echeance}</div>` : ''}`;
        ouvrirModal('modal-credit');
    }
}

// ── Numpad espèces ─────────────────────────────────────
function nk(k) {
    if (k === '⌫') cashStr = cashStr.slice(0, -1);
    else cashStr += k;
    if (cashStr.length > 10) cashStr = cashStr.slice(0, 10);
    majCash();
}
function setCash(v) { cashStr = String(v); majCash(); }
function majCash() {
    const val = parseInt(cashStr || '0');
    const ttc = getTTC();
    const disp = document.getElementById('me-display');
    const btn  = document.getElementById('me-confirm');
    const zone = document.getElementById('me-monnaie');

    // Affichage du montant saisi
    disp.textContent = val > 0 ? val.toLocaleString('fr-FR') + ' ' + DEVISE : '0';

    if (val === 0) {
        // Rien saisi encore
        zone.innerHTML = `<div style="background:#F9F9F6;border-radius:8px;padding:10px 14px;font-size:13px;color:#aaa;text-align:center">
            Saisissez le montant remis par le client
        </div>`;
        btn.disabled = true;
        btn.style.opacity = '.4';
    } else if (val < ttc) {
        // Montant insuffisant
        const manque = ttc - val;
        zone.innerHTML = `<div style="background:#FEF2F2;border:.5px solid #FECACA;border-radius:8px;padding:10px 14px;display:flex;justify-content:space-between;align-items:center">
            <span style="font-size:13px;color:#DC2626;font-weight:600"><i class="ti ti-alert-circle"></i> Montant insuffisant</span>
            <span style="font-size:13px;color:#DC2626;font-weight:700">−${manque.toLocaleString('fr-FR')} ${DEVISE}</span>
        </div>`;
        btn.disabled = true;
        btn.style.opacity = '.4';
    } else {
        // Montant suffisant → monnaie
        const monnaie = val - ttc;
        zone.innerHTML = `<div style="background:#F0FDF4;border:.5px solid #BBF7D0;border-radius:8px;padding:10px 14px;display:flex;justify-content:space-between;align-items:center">
            <span style="font-size:13px;color:#166534;font-weight:600"><i class="ti ti-coins"></i> Monnaie à rendre</span>
            <span style="font-family:'Syne',sans-serif;font-size:1.1rem;font-weight:800;color:#16A34A">${monnaie.toLocaleString('fr-FR')} ${DEVISE}</span>
        </div>`;
        btn.disabled = false;
        btn.style.opacity = '1';
        btn.innerHTML = monnaie > 0
            ? `<i class="ti ti-check"></i> Valider — rendre ${monnaie.toLocaleString('fr-FR')} ${DEVISE}`
            : `<i class="ti ti-check"></i> Valider l'encaissement`;
    }
}

// ── Validation vente ───────────────────────────────────
async function confirmerVente() {
    ['modal-especes','modal-simple','modal-credit'].forEach(m => fermerModal(m));
    const btn = document.getElementById('btn-valider');
    btn.disabled = true;
    btn.innerHTML = '<i class="ti ti-loader"></i> Traitement...';

    const ttc = getTTC();
    const ht0 = panier.reduce((s, p) => s + p.prix * p.quantite, 0);
    const rPct = parseFloat(document.getElementById('remise-input').value) || 0;
    const rFix = parseFloat(document.getElementById('remise-fixe-input').value) || 0;
    const remise = Math.min(ht0 * rPct / 100 + rFix, ht0);
    const ht = ht0 - remise;

    const data = {
        _token        : CSRF,
        produits      : panier,
        client_id     : document.getElementById('client-select').value,
        mode_paiement : modeP,
        notes         : document.getElementById('notes-input').value,
        remise_pct    : rPct,
        remise_fixe   : rFix,
        acompte       : document.getElementById('acompte-input').value || 0,
        date_echeance : document.getElementById('echeance-input').value,
        total_ht      : ht,
        total_tva     : Math.round(ht * TVA),
        total_ttc     : ttc,
    };

    try {
        const res  = await fetch(VENDRE_URL, {
            method  : 'POST',
            headers : { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body    : JSON.stringify(data),
        });
        const json = await res.json();

        if (json.success) {
            lastVente = { ...json, panier: [...panier], ttc, cash: parseInt(cashStr || ttc) };

            // Mise à jour optimiste immédiate du stock affiché sur chaque produit
            panier.forEach(p => {
                const card = document.querySelector(`.prod-card[data-id="${p.id}"]`);
                if (!card) return;
                let newStock = parseInt(card.dataset.stock) - p.quantite;
                if (newStock < 0) newStock = 0;
                card.dataset.stock = newStock;
                const stockEl = card.querySelector('.prod-stock-lbl');
                if (stockEl) {
                    if (newStock <= 0) {
                        stockEl.textContent = 'Rupture';
                        stockEl.style.color = '#EF4444';
                        card.classList.add('rupture');
                        card.onclick = () => notif('Stock épuisé', 'warn');
                    } else if (newStock <= 5) {
                        stockEl.textContent = `⚠ ${newStock} restants`;
                        stockEl.style.color = '#EF4444';
                    } else {
                        stockEl.textContent = `${newStock} en stock`;
                        stockEl.style.color = '';
                    }
                }
            });

            // Mise à jour optimiste des stats de la session
            majStatsOptimiste(ttc, modeP);

            // Afficher le reçu
            afficherRecu(lastVente);

            // Rafraîchir les stats depuis le serveur en arrière-plan
            rafraichirStats();
        } else {
            notif('Erreur lors de la vente', 'warn');
            btn.disabled = false;
            btn.style.opacity = '1';
            calculerTotal();
        }
    } catch(e) {
        notif('Erreur de connexion', 'warn');
        btn.disabled = false;
        btn.style.opacity = '1';
        calculerTotal();
    }
}

function afficherRecu(v) {
    const now     = new Date();
    const dateStr = now.toLocaleDateString('fr-FR', {day:'2-digit',month:'2-digit',year:'numeric'});
    const timeStr = now.toLocaleTimeString('fr-FR', {hour:'2-digit',minute:'2-digit'});

    // Calculs
    const ht0     = v.panier.reduce((s,p) => s + p.prix * p.quantite, 0);
    const rPct    = parseFloat(document.getElementById('remise-input').value) || 0;
    const rFix    = parseFloat(document.getElementById('remise-fixe-input').value) || 0;
    const remise  = Math.min(ht0 * rPct / 100 + rFix, ht0);
    const ht      = ht0 - remise;
    const tva     = Math.round(ht * TVA);
    const cash    = parseInt(cashStr || v.ttc);
    const monnaie = (modeP === 'sur_place' && cash > v.ttc) ? cash - v.ttc : 0;

    const modeLabel = {
        'sur_place'   : 'Espèces',
        'carte'       : 'Carte bancaire',
        'orange_money': 'Orange Money',
        'wero'        : 'Wero',
        'credit'      : 'À crédit',
    }[modeP] || modeP;

    // Header du modal
    document.getElementById('recu-ref-header').textContent = `Réf : ${v.reference} · ${dateStr} à ${timeStr}`;

    // Lignes articles
    const lignes = v.panier.map((p,i) => `
        <tr style="background:${i%2===0?'#FAFAF8':'#fff'}">
            <td style="padding:8px 10px;font-size:13px;font-weight:600">${p.nom}</td>
            <td style="padding:8px 10px;text-align:center;font-size:13px;color:#666">${p.quantite}</td>
            <td style="padding:8px 10px;text-align:right;font-size:13px;color:#666">${p.prix.toLocaleString('fr-FR')}</td>
            <td style="padding:8px 10px;text-align:right;font-size:13px;font-weight:700;color:var(--dark)">${(p.prix*p.quantite).toLocaleString('fr-FR')}</td>
        </tr>`
    ).join('');

    document.getElementById('recu-body').innerHTML = `
        {{-- En-tête boutique --}}
        <div style="text-align:center;padding-bottom:1rem;border-bottom:2px dashed #E5E5E0;margin-bottom:1rem">
            <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.1rem;color:var(--dark)">{{ session('boutique.nom','Ma Boutique') }}</div>
            <div style="font-size:11px;color:#aaa;margin-top:2px">{{ session('boutique.adresse','') }}</div>
            <div style="font-size:11px;color:#aaa">{{ session('boutique.telephone','') }}</div>
        </div>

        {{-- Infos facture --}}
        <div style="display:flex;justify-content:space-between;margin-bottom:1rem;font-size:12px">
            <div style="color:#888">
                <div><strong style="color:var(--dark)">Date :</strong> ${dateStr} à ${timeStr}</div>
                <div><strong style="color:var(--dark)">Réf :</strong> ${v.reference}</div>
                <div><strong style="color:var(--dark)">Caissier :</strong> {{ session('admin_login') }}</div>
            </div>
            <div style="text-align:right;color:#888">
                <div><strong style="color:var(--dark)">Client :</strong> ${document.getElementById('client-select').options[document.getElementById('client-select').selectedIndex].text}</div>
                <div><strong style="color:var(--dark)">Paiement :</strong> ${modeLabel}</div>
            </div>
        </div>

        {{-- Tableau articles --}}
        <table style="width:100%;border-collapse:collapse;margin-bottom:1rem;border:.5px solid #E5E5E0;border-radius:6px;overflow:hidden">
            <thead>
                <tr style="background:var(--dark);color:#fff">
                    <th style="padding:8px 10px;text-align:left;font-size:12px;font-weight:600">Article</th>
                    <th style="padding:8px 10px;text-align:center;font-size:12px;font-weight:600">Qté</th>
                    <th style="padding:8px 10px;text-align:right;font-size:12px;font-weight:600">P.U.</th>
                    <th style="padding:8px 10px;text-align:right;font-size:12px;font-weight:600">Total</th>
                </tr>
            </thead>
            <tbody>${lignes}</tbody>
        </table>

        {{-- Totaux --}}
        <div style="background:#F9F9F6;border-radius:8px;padding:1rem">
            <div style="display:flex;justify-content:space-between;font-size:13px;color:#888;margin-bottom:4px">
                <span>Sous-total HT</span><span>${ht0.toLocaleString('fr-FR')} ${DEVISE}</span>
            </div>
            ${remise > 0 ? `<div style="display:flex;justify-content:space-between;font-size:13px;color:#22C55E;margin-bottom:4px"><span>Remise</span><span>−${remise.toLocaleString('fr-FR')} ${DEVISE}</span></div>` : ''}
            <div style="display:flex;justify-content:space-between;font-size:13px;color:#888;margin-bottom:8px;padding-bottom:8px;border-bottom:.5px solid #E5E5E0">
                <span>TVA ({{ ($tva_taux ?? 18) }}%)</span><span>${tva.toLocaleString('fr-FR')} ${DEVISE}</span>
            </div>
            <div style="display:flex;justify-content:space-between;font-family:'Syne',sans-serif;font-weight:800;font-size:1.1rem">
                <span>TOTAL TTC</span>
                <span style="color:var(--primary)">${v.ttc.toLocaleString('fr-FR')} ${DEVISE}</span>
            </div>
            ${modeP === 'sur_place' ? `
            <div style="margin-top:8px;padding-top:8px;border-top:.5px solid #E5E5E0;font-size:13px">
                <div style="display:flex;justify-content:space-between;color:#666"><span>Reçu</span><span>${cash.toLocaleString('fr-FR')} ${DEVISE}</span></div>
                ${monnaie > 0 ? `<div style="display:flex;justify-content:space-between;color:#22C55E;font-weight:700;margin-top:4px"><span>Monnaie rendue</span><span>${monnaie.toLocaleString('fr-FR')} ${DEVISE}</span></div>` : ''}
            </div>` : ''}
            ${modeP === 'credit' ? `
            <div style="margin-top:8px;padding:8px;background:#FEF3C7;border-radius:6px;font-size:12px;color:#92400E">
                <i class="ti ti-clock"></i> Vente à crédit — restant à payer après acompte
            </div>` : ''}
        </div>

        {{-- Pied de page --}}
        <div style="text-align:center;margin-top:1rem;font-size:11px;color:#bbb;border-top:2px dashed #E5E5E0;padding-top:.75rem">
            Merci pour votre confiance · {{ session('boutique.nom','Ma Boutique') }}
        </div>`;

    ouvrirModal('modal-recu');
}

function imprimerRecu() {
    const w    = window.open('', '_blank', 'width=520,height=700');
    const body = document.getElementById('recu-body').innerHTML;
    w.document.write(`<!DOCTYPE html><html><head><meta charset="utf-8">
        <style>
            body { font-family: 'Arial', sans-serif; font-size: 13px; padding: 24px; color: #1A1A1A; max-width: 480px; margin: 0 auto; }
            table { width: 100%; border-collapse: collapse; }
            th, td { padding: 7px 10px; }
            thead tr { background: #1A1A1A; color: #fff; }
            @media print { body { padding: 0; } }
        </style>
    </head><body>${body}</body></html>`);
    w.document.close();
    setTimeout(() => w.print(), 300);
}

function nouvelleVente() {
    fermerModal('modal-recu');

    // Reset panier
    panier   = [];
    cashStr  = '';
    modeP    = 'sur_place';

    // Reset formulaires
    document.getElementById('remise-input').value    = '0';
    document.getElementById('remise-fixe-input').value = '0';
    document.getElementById('notes-input').value     = '';
    document.getElementById('acompte-input').value   = '0';
    document.getElementById('echeance-input').value  = '';
    document.getElementById('client-select').value   = '';

    // Reset mode paiement → Espèces
    ['sur_place','carte','orange_money','wero','credit'].forEach(x => {
        const el = document.getElementById('mode-' + x);
        if (el) el.classList.toggle('active', x === 'sur_place');
    });
    document.getElementById('credit-zone').style.display = 'none';

    // Incrémenter le numéro de commande
    const refEl = document.getElementById('order-ref');
    if (refEl) {
        const num = parseInt(refEl.textContent.replace('#','')) + 1;
        refEl.textContent = '#' + String(num).padStart(3,'0');
    }

    renderPanier();
    notif('Prêt pour la prochaine vente');
}

// ── Stats temps réel ───────────────────────────────────
// Mise à jour optimiste immédiate (sans attendre le serveur)
function majStatsOptimiste(ttc, mode) {
    const fmt = n => n.toLocaleString('fr-FR') + ' <small style="font-size:11px;font-weight:400">{{ session('boutique.devise','FCFA') }}</small>';

    // Lire les valeurs actuelles
    const parseVal = id => {
        const el = document.getElementById(id);
        if (!el) return 0;
        return parseInt(el.textContent.replace(/\s/g,'').replace('FCFA','')) || 0;
    };

    const total = parseVal('stat-total') + ttc;
    document.getElementById('stat-total').innerHTML = fmt(total);

    if (mode === 'sur_place') {
        const v = parseVal('stat-especes') + ttc;
        document.getElementById('stat-especes').innerHTML = fmt(v);
    } else if (mode === 'carte') {
        const v = parseVal('stat-carte') + ttc;
        document.getElementById('stat-carte').innerHTML = fmt(v);
    } else if (mode === 'orange_money' || mode === 'wero') {
        const v = parseVal('stat-mobile') + ttc;
        document.getElementById('stat-mobile').innerHTML = fmt(v);
    }
}

// Rafraîchissement depuis le serveur en arrière-plan
async function rafraichirStats() {
    try {
        const r    = await fetch('{{ route('admin.caisse.stats') }}', {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        });
        if (!r.ok) return;
        const data = await r.json();
        const fmt  = n => n.toLocaleString('fr-FR') + ' <small style="font-size:11px;font-weight:400">{{ session('boutique.devise','FCFA') }}</small>';
        if (document.getElementById('stat-especes')) document.getElementById('stat-especes').innerHTML = fmt(data.especes);
        if (document.getElementById('stat-carte'))   document.getElementById('stat-carte').innerHTML   = fmt(data.carte);
        if (document.getElementById('stat-mobile'))  document.getElementById('stat-mobile').innerHTML  = fmt(data.mobile);
        if (document.getElementById('stat-total'))   document.getElementById('stat-total').innerHTML   = fmt(data.total);
    } catch(e) {}
}

// ── Filtres catalogue ──────────────────────────────────
function filterProduits(q) {
    const cat = document.getElementById('filter-cat').value;
    document.querySelectorAll('#produits-grid .prod-card').forEach(el => {
        const matchQ = !q || el.dataset.nom.toLowerCase().includes(q.toLowerCase());
        const matchC = !cat || el.dataset.cat == cat;
        el.style.display = matchQ && matchC ? '' : 'none';
    });
}

// ── Modals ─────────────────────────────────────────────
function ouvrirModal(id) { const el = document.getElementById(id); el.style.display = 'flex'; }
function fermerModal(id) { const el = document.getElementById(id); if (el) el.style.display = 'none'; }
function toggleFermerModal() { ouvrirModal('modal-fermer'); }

document.querySelectorAll('.modal-backdrop').forEach(el => {
    el.addEventListener('click', e => { if (e.target === el) fermerModal(el.id); });
});

// ── Notifications ──────────────────────────────────────
function notif(msg, type) {
    const el = document.createElement('div');
    el.className = 'notif-pop' + (type === 'warn' ? ' warn' : '');
    el.textContent = msg;
    document.body.appendChild(el);
    setTimeout(() => el.remove(), 2200);
}
</script>
@endpush
@endif