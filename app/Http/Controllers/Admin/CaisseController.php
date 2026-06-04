<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SessionCaisse;
use App\Models\Vente;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Client;
use Illuminate\Http\Request;

class CaisseController extends Controller {

    public function index() {
        $bid     = session('boutique_id');
        $session = SessionCaisse::where('boutique_id', $bid)
            ->where('statut', 'ouverte')
            ->latest()->first();

        // Si session ouverte, on charge les données POS
        $produits   = collect();
        $categories = collect();
        $clients    = collect();
        $tva_taux   = session('boutique.tva', 18);

        if ($session) {
            $produits = Produit::where('boutique_id', $bid)
                ->where('visible', true)
                ->with(['stock', 'categorie'])
                ->get();

            $categories = Categorie::where('boutique_id', $bid)->get();
            $clients    = Client::where('boutique_id', $bid)->orderBy('prenom')->get();

            // Mettre à jour les totaux de la session en temps réel
            $ventes = Vente::where('boutique_id', $bid)
                ->where('created_at', '>=', $session->ouverture_at)
                ->get();

            $session->total_especes = $ventes->where('mode_paiement', 'sur_place')->sum('total_ttc');
            $session->total_carte   = $ventes->where('mode_paiement', 'carte')->sum('total_ttc');
            $session->total_mobile  = $ventes->whereIn('mode_paiement', ['orange_money', 'wero'])->sum('total_ttc');
            $session->total_ventes  = $ventes->sum('total_ttc');
            // On ne sauvegarde pas ici, juste pour l'affichage temps réel
        }

        return view('admin.caisse.index', compact(
            'session', 'produits', 'categories', 'clients', 'tva_taux'
        ));
    }

    public function ouvrir(Request $request) {
        $bid = session('boutique_id');
        $request->validate(['fond_ouverture' => 'required|numeric|min:0']);

        $existe = SessionCaisse::where('boutique_id', $bid)
            ->where('statut', 'ouverte')->exists();

        if ($existe) return back()->withErrors(['session' => 'Une session est déjà ouverte.']);

        SessionCaisse::create([
            'boutique_id'    => $bid,
            'admin_id'       => session('admin_id'),
            'ouverture_at'   => now(),
            'fond_ouverture' => $request->fond_ouverture,
            'statut'         => 'ouverte',
        ]);

        return back()->with('ok', 'Caisse ouverte.');
    }

    public function fermer(Request $request) {
        $bid     = session('boutique_id');
        $session = SessionCaisse::where('boutique_id', $bid)
            ->where('statut', 'ouverte')->latest()->firstOrFail();

        $ventes = Vente::where('boutique_id', $bid)
            ->where('created_at', '>=', $session->ouverture_at)
            ->get();

        $session->update([
            'fermeture_at'   => now(),
            'fond_fermeture' => $request->fond_fermeture ?? 0,
            'total_especes'  => $ventes->where('mode_paiement', 'sur_place')->sum('total_ttc'),
            'total_carte'    => $ventes->where('mode_paiement', 'carte')->sum('total_ttc'),
            'total_mobile'   => $ventes->whereIn('mode_paiement', ['orange_money', 'wero'])->sum('total_ttc'),
            'total_credit'   => $ventes->where('mode_paiement', 'credit')->sum('total_ttc'),
            'total_ventes'   => $ventes->sum('total_ttc'),
            'statut'         => 'fermee',
            'notes'          => $request->notes,
        ]);

        return back()->with('ok', 'Caisse fermée avec succès.');
    }

    public function historique() {
        $bid      = session('boutique_id');
        $sessions = SessionCaisse::where('boutique_id', $bid)
            ->with('admin')->latest()->paginate(20);
        return view('admin.caisse.historique', compact('sessions'));
    }

    // Endpoint JSON pour rafraîchir les stats en temps réel
    public function stats() {
        $bid     = session('boutique_id');
        $session = SessionCaisse::where('boutique_id', $bid)
            ->where('statut', 'ouverte')->latest()->first();

        if (!$session) {
            return response()->json(['especes'=>0,'carte'=>0,'mobile'=>0,'credit'=>0,'total'=>0]);
        }

        $ventes = Vente::where('boutique_id', $bid)
            ->where('created_at', '>=', $session->ouverture_at)
            ->get();

        return response()->json([
            'especes' => $ventes->where('mode_paiement','sur_place')->sum('total_ttc'),
            'carte'   => $ventes->where('mode_paiement','carte')->sum('total_ttc'),
            'mobile'  => $ventes->whereIn('mode_paiement',['orange_money','wero'])->sum('total_ttc'),
            'credit'  => $ventes->where('mode_paiement','sur_place')->sum('total_ttc'), // crédit stocké comme sur_place
            'total'   => $ventes->sum('total_ttc'),
        ]);
    }
}