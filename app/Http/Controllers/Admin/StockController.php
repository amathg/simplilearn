<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\Stock;
use App\Models\MouvementStock;
use App\Models\Magasin;
use Illuminate\Http\Request;

class StockController extends Controller {

    public function index() {
        $bid      = session('boutique_id');
        $produits = Produit::where('boutique_id', $bid)
            ->with(['stock', 'categorie'])
            ->get();
        $magasins = Magasin::where('boutique_id', $bid)->get();
        $alertes  = $produits->filter(fn($p) => ($p->stock?->quantite ?? 0) <= ($p->stock_minimum ?? 0));
        return view('admin.stocks.index', compact('produits', 'magasins', 'alertes'));
    }

    public function ajuster(Request $request) {
        $bid = session('boutique_id');
        $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite'   => 'required|integer|min:1',
            'type'       => 'required|in:entree,sortie',
            'motif'      => 'nullable|string|max:255',
        ]);

        $produit = Produit::findOrFail($request->produit_id);
        $stock   = Stock::firstOrCreate(
            ['produit_id' => $produit->id],
            ['quantite'   => 0]
        );
        $avant = $stock->quantite;

        if ($request->type === 'entree') {
            $stock->increment('quantite', abs($request->quantite));
        } else {
            $stock->decrement('quantite', abs($request->quantite));
        }

        MouvementStock::create([
            'boutique_id' => $bid,
            'produit_id'  => $produit->id,
            'type'        => $request->type,
            'quantite'    => abs($request->quantite),
            'stock_avant' => $avant,
            'stock_apres' => $stock->fresh()->quantite,
            'motif'       => $request->motif ?? 'Ajustement manuel',
            'admin_id'    => session('admin_id'),
        ]);

        return back()->with('ok', 'Stock mis à jour.');
    }

    public function mouvements() {
        $bid        = session('boutique_id');
        $mouvements = MouvementStock::where('boutique_id', $bid)
            ->with(['produit', 'admin'])
            ->latest()
            ->take(200)
            ->get();
        return view('admin.stocks.mouvements', compact('mouvements'));
    }
}