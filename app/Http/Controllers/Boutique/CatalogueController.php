<?php
namespace App\Http\Controllers\Boutique;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Client;
use App\Models\Vente;
use Illuminate\Http\Request;

class CatalogueController extends Controller {

    public function index($slug, Request $request) {
        $boutique   = Boutique::where('slug', $slug)->firstOrFail();
        $categories = Categorie::where('boutique_id', $boutique->id)
                        ->orderBy('nom')->get();

        $query = Produit::where('boutique_id', $boutique->id)
                    ->where('visible', true)
                    ->with(['categorie','stock']);

        if ($request->cat) {
            $query->where('categorie_id', $request->cat);
        }

        if ($request->q) {
            $query->where('nom', 'ilike', '%'.$request->q.'%');
        }

        $sort = $request->sort ?? 'recent';
        match($sort) {
            'prix_asc'  => $query->orderBy('prix_vente', 'asc'),
            'prix_desc' => $query->orderBy('prix_vente', 'desc'),
            default     => $query->orderBy('created_at', 'desc'),
        };

        $produits     = $query->paginate(20)->withQueryString();
        $panier_count = array_sum(array_column(session('panier_'.$boutique->id, []), 'quantite'));

        $nouveautes = Produit::where('boutique_id', $boutique->id)
                        ->where('visible', true)
                        ->where(fn($q) => $q->where('promo', '>', 0)->orWhere('nouveau', true))
                        ->with(['categorie','stock'])
                        ->take(4)->get();

        return view('boutique.index', compact('boutique','categories','produits','panier_count','nouveautes'));
    }

    public function show($slug, $id) {
        $boutique   = Boutique::where('slug', $slug)->firstOrFail();
        $produit    = Produit::where('boutique_id', $boutique->id)
                        ->with(['categorie','stock'])
                        ->findOrFail($id);
        $similaires = Produit::where('boutique_id', $boutique->id)
                        ->where('categorie_id', $produit->categorie_id)
                        ->where('id', '!=', $produit->id)
                        ->where('visible', true)
                        ->with('stock')
                        ->take(4)->get();
        $panier_count = array_sum(array_column(session('panier_'.$boutique->id, []), 'quantite'));
        return view('boutique.produit', compact('boutique','produit','similaires','panier_count'));
    }

    public function monCompte($slug) {
        $boutique = Boutique::where('slug', $slug)->firstOrFail();
        $client   = Client::find(session('client_id'));
        if (!$client) return redirect()->route('boutique.connexion', $slug);
        $ventes   = Vente::where('client_id', $client->id)
                        ->where('boutique_id', $boutique->id)
                        ->latest()->get();
        return view('boutique.mon-compte', compact('boutique','client','ventes'));
    }
}