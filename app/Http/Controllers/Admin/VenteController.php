<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vente;
use App\Models\VenteLigne;
use App\Models\VenteCredit;
use App\Models\Stock;
use App\Models\MouvementStock;
use App\Models\CompteComptable;
use App\Models\EcritureComptable;
use App\Models\SessionCaisse;
use App\Models\CarteFidelite;
use App\Models\JournalAction;
use App\Models\Notification;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class VenteController extends Controller
{
    public function index()
    {
        $bid    = session('boutique_id');
        $ventes = Vente::where('boutique_id', $bid)->with('client')->latest()->get();
        return view('admin.ventes.index', compact('ventes'));
    }

    public function show(Vente $vente)
    {
        $vente->load(['client', 'lignes.produit']);
        return view('admin.ventes.show', compact('vente'));
    }

    public function update(Request $request, Vente $vente)
    {
        $request->validate(['statut' => 'required|in:en_attente,confirmee,prete,livree,annulee']);
        $vente->update(['statut' => $request->statut]);
        return back()->with('ok', 'Statut mis à jour.');
    }

    public function pos()
    {
        $bid        = session('boutique_id');
        $produits   = \App\Models\Produit::where('boutique_id', $bid)
                        ->where('visible', true)->with(['stock', 'categorie'])->get();
        $categories = \App\Models\Categorie::where('boutique_id', $bid)->get();
        $clients    = Client::where('boutique_id', $bid)->get();
        return view('admin.ventes.pos', compact('produits', 'categories', 'clients'));
    }

    // ══════════════════════════════════════════════════
    //  VENDRE
    // ══════════════════════════════════════════════════
    public function vendre(Request $request)
    {
        $bid = session('boutique_id');

        $request->validate([
            'produits'      => 'required|array|min:1',
            'mode_paiement' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            // ── 1. Calcul des totaux ──────────────────────────────
            $tva_taux    = floatval(session('boutique.tva', 18)) / 100;
            $total_ht0   = 0;

            foreach ($request->produits as $item) {
                $total_ht0 += floatval($item['prix'] ?? 0) * intval($item['quantite'] ?? 1);
            }

            $remise_pct  = floatval($request->remise_pct  ?? 0);
            $remise_fixe = floatval($request->remise_fixe ?? 0);
            $remise      = min($total_ht0 * $remise_pct / 100 + $remise_fixe, $total_ht0);
            $total_ht    = $total_ht0 - $remise;
            $total_tva   = round($total_ht * $tva_taux);
            $total_ttc   = $total_ht + $total_tva;

            // mode_paiement stocké en DB (enum sans 'credit')
            $mode_db  = in_array($request->mode_paiement, ['sur_place','carte','orange_money','wero'])
                        ? $request->mode_paiement
                        : 'sur_place';

            $client_id = $request->client_id ?: null;
            $reference = 'POS-' . strtoupper(Str::random(6));

            // ── 2. Créer la vente ─────────────────────────────────
            $vente = Vente::create([
                'boutique_id'   => $bid,
                'client_id'     => $client_id,
                'reference'     => $reference,
                'statut'        => 'confirmee',
                'total_ht'      => $total_ht,
                'total_tva'     => $total_tva,
                'total_ttc'     => $total_ttc,
                'canal'         => 'pos',
                'mode_paiement' => $mode_db,
                'notes'         => $request->notes ?? null,
            ]);

            // ── 3. Lignes + stock + mouvements ────────────────────
            foreach ($request->produits as $item) {
                $produit_id = intval($item['id']);
                $quantite   = intval($item['quantite'] ?? 1);
                $prix       = floatval($item['prix'] ?? 0);
                $nom        = $item['nom'] ?? '';

                VenteLigne::create([
                    'vente_id'      => $vente->id,
                    'produit_id'    => $produit_id,
                    'nom_produit'   => $nom,
                    'quantite'      => $quantite,
                    'prix_unitaire' => $prix,
                    'remise'        => 0,
                ]);

                $stock = Stock::where('produit_id', $produit_id)->first();
                if ($stock) {
                    $avant = $stock->quantite;
                    $stock->decrement('quantite', $quantite);
                    $apres = $avant - $quantite;

                    MouvementStock::create([
                        'boutique_id' => $bid,
                        'produit_id'  => $produit_id,
                        'type'        => 'sortie',
                        'quantite'    => $quantite,
                        'stock_avant' => $avant,
                        'stock_apres' => max(0, $apres),
                        'motif'       => 'Vente POS',
                        'reference'   => $reference,
                        'admin_id'    => session('admin_id'),
                    ]);

                    // Notification stock faible
                    if ($apres <= 5 && $apres >= 0) {
                        Notification::create([
                            'boutique_id' => $bid,
                            'type'        => 'stock',
                            'titre'       => 'Stock faible',
                            'message'     => "Stock faible pour « {$nom} » : " . max(0, $apres) . " restants.",
                            'lien'        => '/admin/stocks',
                            'lue'         => false,
                        ]);
                    }
                }
            }

            // ── 4. Vente à crédit ─────────────────────────────────
            if ($request->mode_paiement === 'credit') {
                $acompte = floatval($request->acompte ?? 0);
                VenteCredit::create([
                    'boutique_id'     => $bid,
                    'vente_id'        => $vente->id,
                    'client_id'       => $client_id,
                    'montant_total'   => $total_ttc,
                    'montant_paye'    => $acompte,
                    'montant_restant' => $total_ttc - $acompte,
                    'date_echeance'   => $request->date_echeance ?: null,
                    'statut'          => $acompte >= $total_ttc ? 'solde' : 'en_cours',
                ]);
            }

            // ── 5. Comptabilité ───────────────────────────────────
            $this->enregistrerEcritures($bid, $vente, $total_ht, $total_tva, $total_ttc, $reference, $request->mode_paiement);

            // ── 6. Session caisse ─────────────────────────────────
            $session = SessionCaisse::where('boutique_id', $bid)
                ->where('statut', 'ouverte')->latest()->first();

            if ($session) {
                if ($request->mode_paiement === 'credit') {
                    $session->increment('total_credit', $total_ttc);
                } elseif ($mode_db === 'carte') {
                    $session->increment('total_carte', $total_ttc);
                } elseif (in_array($mode_db, ['orange_money', 'wero'])) {
                    $session->increment('total_mobile', $total_ttc);
                } else {
                    $session->increment('total_especes', $total_ttc);
                }
                $session->increment('total_ventes', $total_ttc);
            }

            // ── 7. Points fidélité ────────────────────────────────
            if ($client_id) {
                $carte = CarteFidelite::where('boutique_id', $bid)
                    ->where('client_id', $client_id)
                    ->where('actif', true)->first();
                if ($carte) {
                    $pts = (int) floor($total_ttc / 1000);
                    if ($pts > 0) $carte->increment('points', $pts);
                }
            }

            // ── 8. Journal actions ────────────────────────────────
            JournalAction::create([
                'boutique_id'   => $bid,
                'admin_id'      => session('admin_id'),
                'action'        => 'vente_pos',
                'module'        => 'caisse',
                'description'   => "Vente POS {$reference} — {$total_ttc} " . session('boutique.devise', 'FCFA'),
                'donnees_apres' => [
                    'reference' => $reference,
                    'total_ttc' => $total_ttc,
                    'articles'  => count($request->produits),
                    'mode'      => $request->mode_paiement,
                ],
            ]);

            DB::commit();

            return response()->json([
                'success'   => true,
                'reference' => $reference,
                'total'     => $total_ttc,
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => basename($e->getFile()),
            ], 500);
        }
    }

    // ── Écritures comptables ──────────────────────────────────────
    private function enregistrerEcritures(int $bid, Vente $vente, float $ht, float $tva, float $ttc, string $ref, string $mode): void
    {
        $compte_caisse  = CompteComptable::firstOrCreate(
            ['boutique_id' => $bid, 'numero' => '5111'],
            ['libelle' => 'Caisse', 'type' => 'actif', 'actif' => true]
        );
        $compte_clients = CompteComptable::firstOrCreate(
            ['boutique_id' => $bid, 'numero' => '4111'],
            ['libelle' => 'Clients', 'type' => 'actif', 'actif' => true]
        );
        $compte_ventes  = CompteComptable::firstOrCreate(
            ['boutique_id' => $bid, 'numero' => '7011'],
            ['libelle' => 'Ventes de marchandises', 'type' => 'produit', 'actif' => true]
        );
        $compte_tva     = CompteComptable::firstOrCreate(
            ['boutique_id' => $bid, 'numero' => '4431'],
            ['libelle' => 'TVA collectée', 'type' => 'passif', 'actif' => true]
        );

        $date = now()->toDateString();

        // Débit : Caisse ou Clients
        $compte_debit = $mode === 'credit' ? $compte_clients : $compte_caisse;
        EcritureComptable::create([
            'boutique_id'   => $bid,
            'compte_id'     => $compte_debit->id,
            'journal'       => 'VE',
            'date_ecriture' => $date,
            'libelle'       => ($mode === 'credit' ? 'Créance client ' : 'Encaissement ') . $ref,
            'debit'         => $ttc,
            'credit'        => 0,
            'reference'     => $ref,
        ]);

        // Crédit : Ventes HT
        EcritureComptable::create([
            'boutique_id'   => $bid,
            'compte_id'     => $compte_ventes->id,
            'journal'       => 'VE',
            'date_ecriture' => $date,
            'libelle'       => "Vente POS {$ref}",
            'debit'         => 0,
            'credit'        => $ht,
            'reference'     => $ref,
        ]);

        // Crédit : TVA collectée
        if ($tva > 0) {
            EcritureComptable::create([
                'boutique_id'   => $bid,
                'compte_id'     => $compte_tva->id,
                'journal'       => 'VE',
                'date_ecriture' => $date,
                'libelle'       => "TVA vente {$ref}",
                'debit'         => 0,
                'credit'        => $tva,
                'reference'     => $ref,
            ]);
        }
    }

    // ── Crédits ───────────────────────────────────────────────────
    public function credits()
    {
        $bid     = session('boutique_id');
        $credits = VenteCredit::where('boutique_id', $bid)
            ->with(['client', 'vente'])->latest()->get();
        return view('admin.ventes.credits', compact('credits'));
    }

    public function payerCredit(Request $request, VenteCredit $credit)
    {
        $request->validate(['montant' => 'required|numeric|min:0.01']);
        $bid = session('boutique_id');

        DB::beginTransaction();
        try {
            $credit->montant_paye    += $request->montant;
            $credit->montant_restant -= $request->montant;
            $credit->statut = $credit->montant_restant <= 0 ? 'solde' : 'en_cours';
            $credit->save();

            \App\Models\PaiementCredit::create([
                'vente_credit_id' => $credit->id,
                'montant'         => $request->montant,
                'mode_paiement'   => $request->mode_paiement ?? 'especes',
                'date_paiement'   => now()->toDateString(),
            ]);

            // Comptabilité règlement
            $compte_caisse  = CompteComptable::firstOrCreate(
                ['boutique_id' => $bid, 'numero' => '5111'],
                ['libelle' => 'Caisse', 'type' => 'actif', 'actif' => true]
            );
            $compte_clients = CompteComptable::firstOrCreate(
                ['boutique_id' => $bid, 'numero' => '4111'],
                ['libelle' => 'Clients', 'type' => 'actif', 'actif' => true]
            );
            $ref  = $credit->vente->reference ?? 'CR-' . $credit->id;
            $date = now()->toDateString();

            EcritureComptable::create([
                'boutique_id' => $bid, 'compte_id' => $compte_caisse->id,
                'journal' => 'VE', 'date_ecriture' => $date,
                'libelle' => "Règlement crédit {$ref}",
                'debit' => $request->montant, 'credit' => 0, 'reference' => $ref,
            ]);
            EcritureComptable::create([
                'boutique_id' => $bid, 'compte_id' => $compte_clients->id,
                'journal' => 'VE', 'date_ecriture' => $date,
                'libelle' => "Règlement crédit {$ref}",
                'debit' => 0, 'credit' => $request->montant, 'reference' => $ref,
            ]);

            // Session caisse
            $session = SessionCaisse::where('boutique_id', $bid)
                ->where('statut', 'ouverte')->latest()->first();
            if ($session) {
                $session->increment('total_especes', $request->montant);
                $session->increment('total_ventes',  $request->montant);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['err' => $e->getMessage()]);
        }

        return back()->with('ok', 'Paiement enregistré.');
    }
}