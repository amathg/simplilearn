<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Magasin;
use Illuminate\Http\Request;

class MagasinController extends Controller {

    public function index() {
        $bid      = session('boutique_id');
        $magasins = Magasin::where('boutique_id', $bid)->latest()->get();
        return view('admin.magasins.index', compact('magasins'));
    }

    public function store(Request $request) {
        $bid = session('boutique_id');
        $request->validate(['nom' => 'required|string|max:100']);
        Magasin::create([
            'boutique_id' => $bid,
            'nom'         => $request->nom,
            'adresse'     => $request->adresse,
            'ville'       => $request->ville,
            'telephone'   => $request->telephone,
            'principal'   => $request->boolean('principal'),
            'actif'       => true,
        ]);
        return back()->with('ok', 'Magasin ajouté.');
    }

    public function destroy(Magasin $magasin) {
        $magasin->delete();
        return back()->with('ok', 'Magasin supprimé.');
    }

    public function create() { return redirect()->route('admin.magasins.index'); }
    public function edit(Magasin $magasin) { return redirect()->route('admin.magasins.index'); }
    public function update(Request $request, Magasin $magasin) {
        $magasin->update($request->only(['nom','adresse','ville','telephone','principal','actif']));
        return back()->with('ok', 'Magasin mis à jour.');
    }
    public function show(Magasin $magasin) { return redirect()->route('admin.magasins.index'); }
}