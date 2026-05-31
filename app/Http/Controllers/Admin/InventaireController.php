<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventaire;
use App\Models\InventaireLigne;
use App\Models\Produit;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InventaireController extends Controller {

    public function index() {
        $bid         = session('boutique_id');
        $inventaires = Inventaire::where('boutique_id', $bid)->latest()->get();
        return view('admin.inventaires.index', compact('inventaires'));
    }

    public function create() {
        $bid      = session('boutique_id');
        $produits = Produit::where('boutique_id', $bid)->with('stock')->get();
        return view('admin.inventaires.form', compact('produits'));
    }

    public function store(Request $request) {
        $bid = session('boutique_id');
        $inv = Inventaire::create([
            'boutique_id'     => $bid,
            'reference'       => 'INV-'.strtoupper(Str::random(8)),
            'statut'          => 'en_cours',
            'date_inventaire' => now()->toDateString(),
            'admin_id'        => session('admin_id'),
        ]);

        foreach ($request->produits ?? [] as $pid => $reel) {
            $stock = Stock::where('produit_id', $pid)->first();
            $theorique = $stock?->quantite ?? 0;
            InventaireLigne::create([
                'inventaire_id'    => $inv->id,
                'produit_id'       => $pid,
                'stock_theorique'  => $theorique,
                'stock_reel'       => (int)$reel,
                'ecart'            => (int)$reel - $theorique,
            ]);
        }

        return redirect()->route('admin.inventaires.show', $inv)->with('ok', 'Inventaire créé.');
    }

    public function show(Inventaire $inventaire) {
        $inventaire->load(['lignes.produit']);
        return view('admin.inventaires.show', compact('inventaire'));
    }

    public function valider(Inventaire $inventaire) {
        foreach ($inventaire->lignes as $ligne) {
            Stock::where('produit_id', $ligne->produit_id)
                ->update(['quantite' => $ligne->stock_reel]);
        }
        $inventaire->update(['statut' => 'valide']);
        return back()->with('ok', 'Inventaire validé — stocks mis à jour.');
    }

    public function edit(Inventaire $inventaire) { return redirect()->route('admin.inventaires.index'); }
    public function update(Request $request, Inventaire $inventaire) { return redirect()->route('admin.inventaires.index'); }
    public function destroy(Inventaire $inventaire) {
        $inventaire->delete();
        return back()->with('ok', 'Inventaire supprimé.');
    }
}