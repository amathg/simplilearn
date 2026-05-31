<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProduitController extends Controller {

    public function index() {
        $bid      = session('boutique_id');
        $produits = Produit::where('boutique_id', $bid)
            ->with(['categorie', 'stock'])
            ->latest()->get();
        $categories = Categorie::where('boutique_id', $bid)->orderBy('nom')->get();
        return view('admin.produits.index', compact('produits', 'categories'));
    }

    public function create() {
        $bid        = session('boutique_id');
        $categories = Categorie::where('boutique_id', $bid)->orderBy('nom')->get();
        return view('admin.produits.form', compact('categories'));
    }

    public function store(Request $request) {
        $bid = session('boutique_id');
        $request->validate([
            'nom'          => 'required|string|max:200',
            'prix_vente'   => 'required|numeric|min:0',
            'categorie_id' => 'nullable|exists:categories,id',
        ]);

        $image = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('produits', 'public');
        }

        $produit = Produit::create([
            'boutique_id'  => $bid,
            'categorie_id' => $request->categorie_id,
            'nom'          => $request->nom,
            'description'  => $request->description,
            'prix_vente'   => $request->prix_vente,
            'prix_achat'   => $request->prix_achat ?? 0,
            'promo'        => $request->promo ?? 0,
            'icone'        => $request->icone ?? 'ti-package',
            'image'        => $image,
            'nouveau'      => $request->boolean('nouveau'),
            'visible'      => $request->boolean('visible', true),
        ]);

        Stock::create(['produit_id' => $produit->id, 'quantite' => $request->stock ?? 0]);

        return redirect()->route('admin.produits.index')->with('ok', 'Produit créé avec succès.');
    }

    public function edit(Produit $produit) {
        $bid        = session('boutique_id');
        $categories = Categorie::where('boutique_id', $bid)->orderBy('nom')->get();
        return view('admin.produits.form', compact('produit', 'categories'));
    }

    public function update(Request $request, Produit $produit) {
        $request->validate([
            'nom'        => 'required|string|max:200',
            'prix_vente' => 'required|numeric|min:0',
        ]);

        $image = $produit->image;
        if ($request->hasFile('image')) {
            if ($image) Storage::disk('public')->delete($image);
            $image = $request->file('image')->store('produits', 'public');
        }

        $produit->update([
            'categorie_id' => $request->categorie_id,
            'nom'          => $request->nom,
            'description'  => $request->description,
            'prix_vente'   => $request->prix_vente,
            'prix_achat'   => $request->prix_achat ?? 0,
            'promo'        => $request->promo ?? 0,
            'icone'        => $request->icone ?? 'ti-package',
            'image'        => $image,
            'nouveau'      => $request->boolean('nouveau'),
            'visible'      => $request->boolean('visible', true),
        ]);

        $produit->stock()->update(['quantite' => $request->stock ?? 0]);

        return redirect()->route('admin.produits.index')->with('ok', 'Produit mis à jour.');
    }

    public function destroy(Produit $produit) {
        if ($produit->image) Storage::disk('public')->delete($produit->image);
        $produit->delete();
        return redirect()->route('admin.produits.index')->with('ok', 'Produit supprimé.');
    }

    public function show(Produit $produit) {
        return redirect()->route('admin.produits.edit', $produit);
    }
}