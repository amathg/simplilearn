<?php
namespace App\Http\Controllers\Boutique;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use App\Models\Produit;
use Illuminate\Http\Request;

class PanierController extends Controller {

    private function getPanierKey($boutique_id) {
        return 'panier_' . $boutique_id;
    }

    public function index($slug) {
        $boutique = Boutique::where('slug', $slug)->firstOrFail();
        $key      = $this->getPanierKey($boutique->id);
        $panier   = session($key, []);
        $total    = array_sum(array_map(fn($i) => $i['prix'] * $i['quantite'], $panier));
        return view('boutique.panier', compact('boutique','panier','total'));
    }

    public function ajouter($slug, Request $request) {
        $boutique = Boutique::where('slug', $slug)->firstOrFail();
        $produit  = Produit::where('boutique_id', $boutique->id)
                        ->with('stock')->findOrFail($request->produit_id);

        $stock = $produit->stock?->quantite ?? 0;
        if ($stock <= 0) return back()->with('error', 'Produit épuisé.');

        $key    = $this->getPanierKey($boutique->id);
        $panier = session($key, []);
        $qte    = max(1, (int)$request->quantite);
        $pid    = $produit->id;

        if (isset($panier[$pid])) {
            $panier[$pid]['quantite'] = min($stock, $panier[$pid]['quantite'] + $qte);
        } else {
            $panier[$pid] = [
                'id'       => $produit->id,
                'nom'      => $produit->nom,
                'prix'     => $produit->prix_final,
                'quantite' => min($stock, $qte),
                'image'    => $produit->image,
                'icone'    => $produit->icone,
            ];
        }

        session([$key => $panier]);
        return back()->with('ok', '✓ Ajouté au panier !');
    }

    public function maj($slug, Request $request) {
        $boutique = Boutique::where('slug', $slug)->firstOrFail();
        $key      = $this->getPanierKey($boutique->id);
        $panier   = session($key, []);
        $pid      = $request->produit_id;
        $action   = $request->action;

        if (isset($panier[$pid])) {
            $produit = Produit::with('stock')->find($pid);
            $stock   = $produit?->stock?->quantite ?? 99;

            if ($action === 'plus') {
                $panier[$pid]['quantite'] = min($stock, $panier[$pid]['quantite'] + 1);
            } elseif ($action === 'moins') {
                $panier[$pid]['quantite']--;
                if ($panier[$pid]['quantite'] <= 0) unset($panier[$pid]);
            }
        }

        session([$key => $panier]);
        return redirect()->route('boutique.panier', $slug);
    }

    public function retirer($slug, $id) {
        $boutique = Boutique::where('slug', $slug)->firstOrFail();
        $key      = $this->getPanierKey($boutique->id);
        $panier   = session($key, []);
        unset($panier[$id]);
        session([$key => $panier]);
        return redirect()->route('boutique.panier', $slug);
    }
}