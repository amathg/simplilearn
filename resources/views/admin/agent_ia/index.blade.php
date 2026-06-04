@extends('layouts.admin')
@section('title', 'Agent IA — Publicité Réseaux Sociaux')

@push('styles')
<style>
.reseau-btn { display:flex;flex-direction:column;align-items:center;gap:6px;padding:14px 10px;border:.5px solid #DDD;border-radius:10px;cursor:pointer;transition:all .15s;background:#fff;font-family:inherit;font-size:12px;font-weight:600;color:#666;min-width:80px; }
.reseau-btn:hover { border-color:#888;background:#F9F9F6; }
.reseau-btn.active.ig  { background:linear-gradient(135deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888);color:#fff;border-color:transparent; }
.reseau-btn.active.fb  { background:#1877F2;color:#fff;border-color:transparent; }
.reseau-btn.active.tt  { background:#000;color:#fff;border-color:transparent; }
.reseau-btn.active.all { background:var(--dark);color:#fff;border-color:transparent; }
.reseau-btn i { font-size:24px; }
.contenu-box { width:100%;min-height:180px;border:.5px solid #DDD;border-radius:8px;padding:12px;font-family:inherit;font-size:13px;line-height:1.6;resize:vertical;outline:none;background:#FAFAF8; }
.contenu-box:focus { border-color:#888;background:#fff; }
.campagne-card { background:#fff;border:.5px solid #E5E5E0;border-radius:10px;padding:1rem;margin-bottom:.75rem;transition:all .15s; }
.campagne-card:hover { border-color:#CCC;box-shadow:0 2px 8px rgba(0,0,0,.06); }
.reseau-pill { display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600; }
.pill-ig  { background:#FDE8F0;color:#C13584; }
.pill-fb  { background:#E7F0FD;color:#1877F2; }
.pill-tt  { background:#F0F0F0;color:#000; }
.pill-all { background:#F0F0EB;color:#666; }
.generating { display:none;text-align:center;padding:2rem; }
.generating.active { display:block; }
.spinner { width:32px;height:32px;border:3px solid #F0F0EB;border-top-color:var(--primary);border-radius:50%;animation:spin .8s linear infinite;margin:0 auto 1rem; }
@keyframes spin { to { transform:rotate(360deg); } }
</style>
@endpush

@section('content')

@if(session('ok'))
<div class="alert-ok"><i class="ti ti-circle-check"></i> {{ session('ok') }}</div>
@endif

<div class="page-header">
    <div>
        <h1>Agent IA — Publicité</h1>
        <p style="font-size:13px;color:#888;margin-top:2px">Générez du contenu publicitaire pour vos réseaux sociaux en quelques secondes</p>
    </div>
</div>

{{-- Stats --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem">
    <div class="stat-card">
        <div class="stat-icon" style="background:#F0F0EB;color:#666"><i class="ti ti-speakerphone"></i></div>
        <div><span class="stat-val">{{ $stats['total'] }}</span><span class="stat-lbl">Total campagnes</span></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#F0FDF4;color:#22C55E"><i class="ti ti-circle-check"></i></div>
        <div><span class="stat-val">{{ $stats['publiees'] }}</span><span class="stat-lbl">Publiées</span></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#EFF6FF;color:#3B82F6"><i class="ti ti-clock"></i></div>
        <div><span class="stat-val">{{ $stats['programmes'] }}</span><span class="stat-lbl">Programmées</span></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FFFBEB;color:#F59E0B"><i class="ti ti-edit"></i></div>
        <div><span class="stat-val">{{ $stats['brouillons'] }}</span><span class="stat-lbl">Brouillons</span></div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 380px;gap:1.5rem;align-items:start">

    {{-- GÉNÉRATEUR --}}
    <div>
        <div class="card" style="padding:1.5rem;margin-bottom:1.5rem">
            <h2 style="font-family:'Syne',sans-serif;font-weight:800;font-size:1rem;margin-bottom:1.25rem">
                <i class="ti ti-wand" style="color:var(--primary)"></i> Générer une publicité
            </h2>

            {{-- Réseau --}}
            <div style="margin-bottom:1.25rem">
                <label style="font-size:12px;font-weight:600;color:#888;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:.625rem">Réseau social</label>
                <div style="display:flex;gap:.625rem;flex-wrap:wrap">
                    <button class="reseau-btn ig active" onclick="setReseau('instagram',this)">
                        <i class="ti ti-brand-instagram"></i>Instagram
                    </button>
                    <button class="reseau-btn fb" onclick="setReseau('facebook',this)">
                        <i class="ti ti-brand-facebook"></i>Facebook
                    </button>
                    <button class="reseau-btn tt" onclick="setReseau('tiktok',this)">
                        <i class="ti ti-brand-tiktok"></i>TikTok
                    </button>
                    <button class="reseau-btn all" onclick="setReseau('tous',this)">
                        <i class="ti ti-world"></i>Tous
                    </button>
                </div>
                <input type="hidden" id="reseau-val" value="instagram">
            </div>

            {{-- Type de contenu --}}
            <div style="margin-bottom:1.25rem">
                <label style="font-size:12px;font-weight:600;color:#888;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:.625rem">Type de contenu</label>
                <div style="display:flex;gap:.5rem;flex-wrap:wrap">
                    @foreach(['post'=>'Post','story'=>'Story','video'=>'Vidéo','carousel'=>'Carousel'] as $val => $lbl)
                    <label style="display:flex;align-items:center;gap:6px;padding:7px 14px;border:.5px solid #DDD;border-radius:6px;cursor:pointer;font-size:13px;background:#fff">
                        <input type="radio" name="type_contenu" value="{{ $val }}" {{ $val==='post'?'checked':'' }} style="accent-color:var(--primary)"> {{ $lbl }}
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Produit optionnel --}}
            <div style="margin-bottom:1.25rem">
                <label style="font-size:12px;font-weight:600;color:#888;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:.625rem">Produit à promouvoir (optionnel)</label>
                <select id="produit-select" style="width:100%;border:.5px solid #DDD;border-radius:6px;padding:8px 12px;font-family:inherit;font-size:13px;outline:none">
                    <option value="">— Publicité générale de la boutique —</option>
                    @foreach($produits as $p)
                    <option value="{{ $p->id }}">{{ $p->nom }} — {{ number_format($p->prix_final,0,',',' ') }} {{ session('boutique.devise','FCFA') }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Prompt --}}
            <div style="margin-bottom:1.25rem">
                <label style="font-size:12px;font-weight:600;color:#888;text-transform:uppercase;letter-spacing:.5px;display:block;margin-bottom:.625rem">Décrivez votre publicité</label>
                <textarea id="prompt-input" class="contenu-box" placeholder="Ex: Je veux attirer des clients pour les soldes de fin de mois, mettez en avant nos prix imbattables et la qualité de nos produits..."></textarea>
                <div style="font-size:11px;color:#aaa;margin-top:4px">Soyez précis : ton souhaité, promotion, cible, message clé...</div>
            </div>

            <button onclick="genererContenu()" id="btn-generer"
                    style="width:100%;padding:13px;background:var(--dark);color:#fff;border:none;border-radius:8px;font-size:14px;font-weight:700;cursor:pointer;font-family:inherit;display:flex;align-items:center;justify-content:center;gap:8px;transition:opacity .15s">
                <i class="ti ti-sparkles" style="font-size:18px"></i> Générer avec l'IA
            </button>
        </div>

        {{-- Résultat généré --}}
        <div id="resultat-zone" style="display:none">
            <div class="card" style="padding:1.5rem">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem">
                    <h2 style="font-family:'Syne',sans-serif;font-weight:800;font-size:1rem">
                        <i class="ti ti-sparkles" style="color:var(--primary)"></i> Contenu généré
                    </h2>
                    <div style="display:flex;gap:.5rem">
                        <button onclick="copierContenu()" class="btn btn-xs" style="background:#F5F5F0;border:.5px solid #DDD;color:#666">
                            <i class="ti ti-copy"></i> Copier
                        </button>
                        <button onclick="regenerer()" class="btn btn-xs" style="background:#F5F5F0;border:.5px solid #DDD;color:#666">
                            <i class="ti ti-refresh"></i> Regénérer
                        </button>
                    </div>
                </div>

                {{-- Spinner --}}
                <div class="generating" id="spinner-zone">
                    <div class="spinner"></div>
                    <div style="font-size:13px;color:#888">L'IA génère votre contenu...</div>
                </div>

                <textarea id="contenu-genere" class="contenu-box" style="min-height:220px;display:none"></textarea>

                <div id="actions-zone" style="display:none;margin-top:1rem">
                    <div style="display:flex;gap:.5rem;flex-wrap:wrap">
                        <button onclick="sauvegarderBrouillon()" class="btn" style="background:#F5F5F0;border:.5px solid #DDD;color:#666;font-size:13px">
                            <i class="ti ti-device-floppy"></i> Sauvegarder
                        </button>
                        <button onclick="ouvrirProgrammer()" class="btn" style="background:#EFF6FF;color:#3B82F6;border:.5px solid #BFDBFE;font-size:13px">
                            <i class="ti ti-calendar-event"></i> Programmer
                        </button>
                        <a id="btn-partager-ig" href="#" target="_blank" style="display:none"
                           class="btn" style="background:#FDE8F0;color:#C13584;border:.5px solid #F0C0DA;font-size:13px">
                            <i class="ti ti-brand-instagram"></i> Ouvrir Instagram
                        </a>
                        <a id="btn-partager-fb" href="#" target="_blank" style="display:none"
                           class="btn" style="background:#E7F0FD;color:#1877F2;border:.5px solid #C0D4F5;font-size:13px">
                            <i class="ti ti-brand-facebook"></i> Ouvrir Facebook
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- HISTORIQUE --}}
    <div style="position:sticky;top:72px">
        <div class="card" style="padding:0;overflow:hidden">
            <div style="background:var(--dark);color:#fff;padding:.875rem 1.1rem;font-family:'Syne',sans-serif;font-weight:700;font-size:13px">
                <i class="ti ti-history"></i> Historique des campagnes
            </div>
            <div style="max-height:calc(100vh - 200px);overflow-y:auto">
                @forelse($campagnes as $c)
                <div class="campagne-card" style="border-radius:0;border-left:none;border-right:none;border-top:none;border-bottom:.5px solid #F0F0EB;padding:.875rem 1rem">
                    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:.5rem;margin-bottom:.5rem">
                        <div style="font-size:13px;font-weight:600;color:var(--dark);line-height:1.3">{{ Str::limit($c->titre, 35) }}</div>
                        <span class="reseau-pill pill-{{ $c->reseau === 'tous' ? 'all' : $c->reseau }}">
                            {{ $c->reseau_label }}
                        </span>
                    </div>
                    <div style="font-size:12px;color:#888;margin-bottom:.625rem;line-height:1.4">{{ Str::limit($c->contenu_genere, 80) }}</div>
                    <div style="display:flex;align-items:center;justify-content:space-between">
                        <span class="badge {{ $c->statut_badge }}">{{ ucfirst($c->statut) }}</span>
                        <div style="display:flex;gap:4px">
                            <button onclick="chargerCampagne('{{ addslashes($c->contenu_genere) }}')"
                                    class="btn btn-xs" style="background:#F5F5F0;border:.5px solid #DDD;color:#666" title="Charger">
                                <i class="ti ti-edit"></i>
                            </button>
                            <form method="POST" action="{{ route('admin.agent-ia.destroy', $c) }}" onsubmit="return confirm('Supprimer ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-xs" style="background:#FEF2F2;color:#DC2626;border:.5px solid #FECACA" title="Supprimer">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div style="font-size:10px;color:#bbb;margin-top:4px">{{ $c->created_at->diffForHumans() }}</div>
                </div>
                @empty
                <div style="padding:2rem;text-align:center;color:#bbb;font-size:13px">
                    <i class="ti ti-speakerphone" style="font-size:2rem;display:block;margin-bottom:.5rem"></i>
                    Aucune campagne générée
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Modal programmer --}}
<div id="modal-programmer" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:200;align-items:center;justify-content:center"
     onclick="if(event.target===this)this.style.display='none'">
    <div style="background:#fff;border-radius:14px;padding:1.75rem;width:380px;max-width:95vw">
        <h3 style="font-family:'Syne',sans-serif;font-weight:800;margin-bottom:1rem"><i class="ti ti-calendar-event"></i> Programmer la publication</h3>
        <div class="fg" style="margin-bottom:1rem">
            <label>Date et heure de publication</label>
            <input type="datetime-local" id="programme-at" style="width:100%" min="{{ now()->format('Y-m-d\TH:i') }}">
        </div>
        <div style="background:#FFFBEB;border:.5px solid #FDE68A;border-radius:8px;padding:.75rem;font-size:12px;color:#92400E;margin-bottom:1rem">
            <i class="ti ti-info-circle"></i> La connexion aux APIs Instagram, Facebook et TikTok est requise pour la publication automatique. Vous pouvez aussi copier le contenu manuellement.
        </div>
        <div style="display:flex;gap:.5rem">
            <button onclick="document.getElementById('modal-programmer').style.display='none'" class="btn" style="flex:1;background:#F5F5F0;border:.5px solid #DDD;color:#666">Annuler</button>
            <button onclick="confirmerProgrammer()" class="btn btn-gold" style="flex:2"><i class="ti ti-check"></i> Confirmer</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
var CSRF       = "{{ csrf_token() }}";
var GENERER_URL= "{{ route('admin.agent-ia.generer') }}";
var currentId  = null;
var reseauActif= 'instagram';

function setReseau(val, btn) {
    reseauActif = val;
    document.getElementById('reseau-val').value = val;
    document.querySelectorAll('.reseau-btn').forEach(b => {
        b.classList.remove('active');
    });
    btn.classList.add('active');
}

async function genererContenu() {
    var prompt = document.getElementById('prompt-input').value.trim();
    if (!prompt) { alert('Décrivez votre publicité d\'abord.'); return; }

    var type    = document.querySelector('input[name="type_contenu"]:checked').value;
    var produit = document.getElementById('produit-select').value;
    var btn     = document.getElementById('btn-generer');

    btn.disabled   = true;
    btn.innerHTML  = '<div style="width:18px;height:18px;border:2px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .8s linear infinite"></div> Génération en cours...';

    document.getElementById('resultat-zone').style.display   = 'block';
    document.getElementById('spinner-zone').classList.add('active');
    document.getElementById('contenu-genere').style.display  = 'none';
    document.getElementById('actions-zone').style.display    = 'none';

    try {
        var res  = await fetch(GENERER_URL, {
            method : 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body   : JSON.stringify({
                reseau       : reseauActif,
                type_contenu : type,
                prompt       : prompt,
                produit_id   : produit || null,
            }),
        });
        var data = await res.json();

        document.getElementById('spinner-zone').classList.remove('active');

        if (data.success) {
            currentId = data.id;
            var box   = document.getElementById('contenu-genere');
            box.value = data.contenu;
            box.style.display = 'block';
            document.getElementById('actions-zone').style.display = 'flex';

            // Afficher liens réseaux
            if (reseauActif === 'instagram' || reseauActif === 'tous') {
                var btnIg = document.getElementById('btn-partager-ig');
                btnIg.href = 'https://www.instagram.com/';
                btnIg.style.display = 'inline-flex';
            }
            if (reseauActif === 'facebook' || reseauActif === 'tous') {
                var txtEncode = encodeURIComponent(data.contenu.substring(0, 500));
                var btnFb = document.getElementById('btn-partager-fb');
                btnFb.href = 'https://www.facebook.com/sharer/sharer.php?quote=' + txtEncode;
                btnFb.style.display = 'inline-flex';
            }
        } else {
            alert('Erreur : ' + (data.error || 'Réessayez.'));
        }
    } catch(e) {
        document.getElementById('spinner-zone').classList.remove('active');
        alert('Erreur de connexion.');
    }

    btn.disabled  = false;
    btn.innerHTML = '<i class="ti ti-sparkles" style="font-size:18px"></i> Générer avec l\'IA';
}

function copierContenu() {
    var box = document.getElementById('contenu-genere');
    navigator.clipboard.writeText(box.value).then(function() {
        var btn = event.target.closest('button');
        btn.innerHTML = '<i class="ti ti-check"></i> Copié !';
        setTimeout(function() { btn.innerHTML = '<i class="ti ti-copy"></i> Copier'; }, 2000);
    });
}

function regenerer() {
    genererContenu();
}

function chargerCampagne(contenu) {
    var box = document.getElementById('contenu-genere');
    box.value = contenu;
    document.getElementById('resultat-zone').style.display  = 'block';
    box.style.display = 'block';
    document.getElementById('actions-zone').style.display   = 'flex';
    document.getElementById('spinner-zone').classList.remove('active');
    box.scrollIntoView({ behavior: 'smooth' });
}

function sauvegarderBrouillon() {
    if (!currentId) return;
    var contenu = document.getElementById('contenu-genere').value;
    fetch('/admin/agent-ia/' + currentId + '/sauvegarder', {
        method : 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body   : JSON.stringify({ contenu: contenu, statut: 'brouillon' }),
    }).then(function() {
        location.reload();
    });
}

function ouvrirProgrammer() {
    document.getElementById('modal-programmer').style.display = 'flex';
}

function confirmerProgrammer() {
    document.getElementById('modal-programmer').style.display = 'none';
    alert('Campagne programmée. La publication automatique sera disponible après connexion aux APIs des réseaux sociaux.');
}
</script>
@endpush