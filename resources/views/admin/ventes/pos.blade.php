@extends('layouts.admin')
@section('title', 'Point de vente')
@section('content')

<div class="page-header">
  <h1>Point de vente (POS)</h1>
  <span style="font-size:13px;color:#888">{{ now()->format('d/m/Y H:i') }}</span>
</div>

<div style="display:grid;grid-template-columns:1fr 380px;gap:1.5rem;align-items:start">

  <!-- CATALOGUE -->
  <div>
    <div style="display:flex;gap:.75rem;margin-bottom:1rem;flex-wrap:wrap">
      <input type="text" id="search-produit" placeholder="Rechercher un produit..." 
             style="flex:1;border:.5px solid #DDD;border-radius:6px;padding:9px 13px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none"
             oninput="filterProduits(this.value)">
      <select id="filter-cat" onchange="filterProduits(document.getElementById('search-produit').value)"
              style="border:.5px solid #DDD;border-radius:6px;padding:9px 13px;font-size:13px;font-family:'DM Sans',sans-serif;outline:none">
        <option value="">Toutes catégories</option>
        @foreach($categories as $cat)
        <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
        @endforeach
      </select>
    </div>

    <div id="produits-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:.75rem">
      @foreach($produits as $p)
      @php $stock = $p->stock?->quantite ?? 0; @endphp
      <div class="pos-card" 
           data-id="{{ $p->id }}" 
           data-nom="{{ $p->nom }}" 
           data-prix="{{ $p->prix_final }}"
           data-stock="{{ $stock }}"
           data-cat="{{ $p->categorie_id }}"
           onclick="{{ $stock > 0 ? 'ajouterPanier(this)' : '' }}"
           style="background:#fff;border:.5px solid #E5E5E0;border-radius:8px;padding:1rem;cursor:{{ $stock > 0 ? 'pointer' : 'not-allowed' }};transition:all .2s;opacity:{{ $stock > 0 ? '1' : '.5' }};text-align:center">
        <div style="font-size:2rem;margin-bottom:.5rem">
          <i class="ti {{ $p->icone ?? 'ti-package' }}" style="color:var(--primary)"></i>
        </div>
        <div style="font-size:12px;font-weight:700;margin-bottom:4px;line-height:1.3">{{ Str::limit($p->nom, 25) }}</div>
        <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:14px;color:var(--primary)">
          {{ number_format($p->prix_final, 0, ',', ' ') }}
        </div>
        <div style="font-size:10px;color:{{ $stock <= 3 ? '#EF4444' : '#888' }};margin-top:3px">
          Stock : {{ $stock }}
        </div>
      </div>
      @endforeach
    </div>
  </div>

  <!-- PANIER -->
  <div style="position:sticky;top:80px">
    <div class="card" style="padding:0;overflow:hidden">
      <div style="background:var(--dark);color:#fff;padding:1rem 1.25rem;font-family:'Syne',sans-serif;font-weight:700;font-size:14px;display:flex;align-items:center;justify-content:space-between">
        <span><i class="ti ti-shopping-cart"></i> Panier</span>
        <button onclick="viderPanier()" style="background:rgba(255,255,255,.1);border:none;color:rgba(255,255,255,.7);padding:4px 10px;border-radius:4px;cursor:pointer;font-size:11px">Vider</button>
      </div>

      <div id="panier-items" style="max-height:300px;overflow-y:auto;min-height:80px">
        <div id="panier-vide" style="padding:2rem;text-align:center;color:#aaa;font-size:13px">
          <i class="ti ti-shopping-cart-off" style="font-size:2rem;display:block;margin-bottom:.5rem"></i>
          Panier vide
        </div>
      </div>

      <div style="padding:1rem;border-top:.5px solid #F0F0EB">
        <!-- Client -->
        <div class="fg" style="margin-bottom:.75rem">
          <label>Client (optionnel)</label>
          <select id="client-select" style="width:100%">
            <option value="">— Client anonyme —</option>
            @foreach($clients as $cl)
            <option value="{{ $cl->id }}">{{ $cl->prenom }} {{ $cl->nom }}</option>
            @endforeach
          </select>
        </div>

        <!-- Mode paiement -->
        <div class="fg" style="margin-bottom:.75rem">
          <label>Mode de paiement</label>
          <select id="mode-paiement" style="width:100%">
            <option value="especes">💵 Espèces</option>
            <option value="carte">💳 Carte</option>
            <option value="orange_money">🟠 Orange Money</option>
            <option value="wero">🟣 Wero</option>
            <option value="credit">📋 À crédit</option>
          </select>
        </div>

        <!-- Total -->
        <div style="display:flex;justify-content:space-between;align-items:center;padding:.75rem 0;border-top:.5px solid #F0F0EB;border-bottom:.5px solid #F0F0EB;margin-bottom:.75rem">
          <span style="font-family:'Syne',sans-serif;font-weight:700">TOTAL</span>
          <span id="total-display" style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.25rem;color:var(--primary)">0 {{ session('boutique.devise','FCFA') }}</span>
        </div>

        <button onclick="validerVente()" id="btn-valider"
                style="width:100%;background:var(--primary);color:#1A1A1A;border:none;border-radius:8px;padding:13px;font-size:14px;font-weight:800;cursor:pointer;font-family:'DM Sans',sans-serif;display:flex;align-items:center;justify-content:center;gap:8px">
          <i class="ti ti-check" style="font-size:18px"></i> Valider la vente
        </button>
      </div>
    </div>
  </div>
</div>

<!-- REÇU MODAL -->
<div id="modal-recu" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:100;align-items:center;justify-content:center">
  <div style="background:#fff;border-radius:12px;padding:2rem;max-width:360px;width:100%;text-align:center">
    <div style="width:64px;height:64px;background:#22C55E;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-size:32px;color:#fff">
      <i class="ti ti-check"></i>
    </div>
    <h2 style="font-family:'Syne',sans-serif;font-weight:800;margin-bottom:.5rem">Vente enregistrée !</h2>
    <p id="recu-ref" style="color:#888;margin-bottom:1.5rem"></p>
    <p id="recu-total" style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.5rem;color:var(--primary);margin-bottom:2rem"></p>
    <button onclick="nouvelleVente()" style="width:100%;background:var(--primary);color:#1A1A1A;border:none;border-radius:8px;padding:12px;font-size:14px;font-weight:700;cursor:pointer;font-family:'DM Sans',sans-serif">
      <i class="ti ti-plus"></i> Nouvelle vente
    </button>
  </div>
</div>

@endsection

@push('scripts')
<script>
let panier = [];

function ajouterPanier(el) {
    const id    = parseInt(el.dataset.id);
    const nom   = el.dataset.nom;
    const prix  = parseFloat(el.dataset.prix);
    const stock = parseInt(el.dataset.stock);

    const exist = panier.find(p => p.id === id);
    if (exist) {
        if (exist.quantite < stock) exist.quantite++;
        else return alert('Stock insuffisant !');
    } else {
        panier.push({id, nom, prix, quantite: 1, stock});
    }
    renderPanier();
    el.style.transform = 'scale(0.95)';
    setTimeout(() => el.style.transform = '', 150);
}

function renderPanier() {
    const container = document.getElementById('panier-items');
    const vide      = document.getElementById('panier-vide');
    const total     = panier.reduce((s, p) => s + p.prix * p.quantite, 0);

    document.getElementById('total-display').textContent =
        total.toLocaleString('fr-FR') + ' {{ session('boutique.devise','FCFA') }}';

    if (panier.length === 0) {
        container.innerHTML = '';
        container.appendChild(vide);
        vide.style.display = 'block';
        return;
    }

    vide.style.display = 'none';
    container.innerHTML = panier.map(p => `
        <div style="display:flex;align-items:center;gap:.5rem;padding:.625rem 1rem;border-bottom:.5px solid #F7F7F5">
            <div style="flex:1">
                <div style="font-size:12px;font-weight:600">${p.nom}</div>
                <div style="font-size:11px;color:#888">${p.prix.toLocaleString('fr-FR')} × ${p.quantite}</div>
            </div>
            <div style="display:flex;align-items:center;gap:4px">
                <button onclick="changeQte(${p.id},-1)" style="width:22px;height:22px;border:.5px solid #DDD;border-radius:4px;background:#fff;cursor:pointer;font-size:14px">−</button>
                <span style="font-size:12px;font-weight:700;min-width:20px;text-align:center">${p.quantite}</span>
                <button onclick="changeQte(${p.id},1)" style="width:22px;height:22px;border:.5px solid #DDD;border-radius:4px;background:#fff;cursor:pointer;font-size:14px">+</button>
                <button onclick="retirerPanier(${p.id})" style="width:22px;height:22px;border:none;background:none;cursor:pointer;color:#EF4444;font-size:16px">×</button>
            </div>
            <div style="font-family:'Syne',sans-serif;font-weight:800;font-size:13px;color:var(--primary);min-width:70px;text-align:right">
                ${(p.prix * p.quantite).toLocaleString('fr-FR')}
            </div>
        </div>
    `).join('');
}

function changeQte(id, delta) {
    const p = panier.find(p => p.id === id);
    if (!p) return;
    p.quantite += delta;
    if (p.quantite <= 0) panier = panier.filter(p => p.id !== id);
    if (p.quantite > p.stock) p.quantite = p.stock;
    renderPanier();
}

function retirerPanier(id) {
    panier = panier.filter(p => p.id !== id);
    renderPanier();
}

function viderPanier() {
    panier = [];
    renderPanier();
}

function filterProduits(q) {
    const cat = document.getElementById('filter-cat').value;
    document.querySelectorAll('.pos-card').forEach(el => {
        const nom     = el.dataset.nom.toLowerCase();
        const catEl   = el.dataset.cat;
        const matchQ  = !q || nom.includes(q.toLowerCase());
        const matchC  = !cat || catEl == cat;
        el.style.display = matchQ && matchC ? '' : 'none';
    });
}

async function validerVente() {
    if (panier.length === 0) return alert('Panier vide !');

    const btn = document.getElementById('btn-valider');
    btn.disabled = true;
    btn.textContent = 'Traitement...';

    const data = {
        _token        : '{{ csrf_token() }}',
        produits      : panier,
        client_id     : document.getElementById('client-select').value,
        mode_paiement : document.getElementById('mode-paiement').value,
    };

    try {
        const res  = await fetch('{{ route('admin.ventes.vendre') }}', {
            method  : 'POST',
            headers : {'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            body    : JSON.stringify(data),
        });
        const json = await res.json();

        if (json.success) {
            document.getElementById('recu-ref').textContent   = 'Réf : ' + json.reference;
            document.getElementById('recu-total').textContent = json.total.toLocaleString('fr-FR') + ' {{ session('boutique.devise','FCFA') }}';
            document.getElementById('modal-recu').style.display = 'flex';
        } else {
            alert('Erreur lors de la vente.');
        }
    } catch(e) {
        alert('Erreur de connexion.');
    }

    btn.disabled = false;
    btn.innerHTML = '<i class="ti ti-check"></i> Valider la vente';
}

function nouvelleVente() {
    panier = [];
    renderPanier();
    document.getElementById('modal-recu').style.display = 'none';
    location.reload();
}
</script>
@endpush