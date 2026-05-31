<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vente;
use App\Models\VenteLigne;
use App\Models\VenteCredit;
use App\Models\Produit;
use App\Models\Stock;
use App\Models\Client;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VenteController extends Controller {

    public function index() {
        $bid    = session('boutique_id');
        $ventes = Vente::where('boutique_id', $bid)
            ->with('client')->latest()->get();
        return view('admin.ventes.index', compact('ventes'));
    }

    public function show(Vente $vente) {
        $vente->load(['client','lignes.produit']);
        return view('admin.ventes.show', compact('vente'));
    }

    public function update(Request $request, Vente $vente) {
        $request->validate(['statut' => 'required|in:en_attente,confirmee,prete,livree,annulee']);
        $vente->update(['statut' => $request->statut]);
        return back()->with('ok', 'Statut mis à jour.');
    }

    // ── POS ──────────────────────────────────────────────
    public function pos() {
        $bid      = session('boutique_id');
        $produits = Produit::where('boutique_id', $bid)
            ->where('visible', true)
            ->with(['stock','categorie'])
            ->get();
        $categories = \App\Models\Categorie::where('boutique_id', $bid)->get();
        $clients    = Client::where('boutique_id', $bid)->get();
        return view('admin.ventes.pos', compact('produits','categories','clients'));
    }

    public function vendre(Request $request) {
        $bid = session('boutique_id');
        $request->validate([
            'produits'      => 'required|array',
            'mode_paiement' => 'required',
        ]);

        $total = 0;
        foreach ($request->produits as $item) {
            $total += $item['prix'] * $item['quantite'];
        }

        $client_id = $request->client_id ?? null;

        // Créer client si nouveau
        if ($request->client_nom && !$client_id) {
            $client = Client::create([
                'boutique_id' => $bid,
                'prenom'      => $request->client_nom,
                'nom'         => '',
                'email'       => $request->client_email ?? 'pos-'.time().'@boutique.com',
                'telephone'   => $request->client_tel ?? '',
            ]);
            $client_id = $client->id;
        }

        $reference = 'POS-'.strtoupper(Str::random(6));

        $vente = Vente::create([
            'boutique_id'   => $bid,
            'client_id'     => $client_id,
            'reference'     => $reference,
            'statut'        => 'confirmee',
            'total_ht'      => $total,
            'total_tva'     => 0,
            'total_ttc'     => $total,
            'canal'         => 'pos',
            'mode_paiement' => $request->mode_paiement,
            'notes'         => $request->notes,
        ]);

        foreach ($request->produits as $item) {
            VenteLigne::create([
                'vente_id'      => $vente->id,
                'produit_id'    => $item['id'],
                'nom_produit'   => $item['nom'],
                'quantite'      => $item['quantite'],
                'prix_unitaire' => $item['prix'],
            ]);
            Stock::where('produit_id', $item['id'])
                ->decrement('quantite', $item['quantite']);
        }

        // Vente à crédit
        if ($request->mode_paiement === 'credit') {
            VenteCredit::create([
                'boutique_id'    => $bid,
                'vente_id'       => $vente->id,
                'client_id'      => $client_id,
                'montant_total'  => $total,
                'montant_paye'   => $request->acompte ?? 0,
                'montant_restant'=> $total - ($request->acompte ?? 0),
                'date_echeance'  => $request->date_echeance,
            ]);
        }

        return response()->json([
            'success'   => true,
            'reference' => $reference,
            'total'     => $total,
        ]);
    }

    public function credits() {
        $bid     = session('boutique_id');
        $credits = VenteCredit::where('boutique_id', $bid)
            ->with(['client','vente'])->latest()->get();
        return view('admin.ventes.credits', compact('credits'));
    }

    public function payerCredit(Request $request, VenteCredit $credit) {
        $request->validate(['montant' => 'required|numeric|min:0']);
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

        return back()->with('ok', 'Paiement enregistré.');
    }
}