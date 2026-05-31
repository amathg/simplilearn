<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Marque;
use Illuminate\Http\Request;

class MarqueController extends Controller {

    public function index() {
        $bid    = session('boutique_id');
        $marques = Marque::where('boutique_id', $bid)->withCount('produits')->latest()->get();
        return view('admin.marques.index', compact('marques'));
    }

    public function store(Request $request) {
        $bid = session('boutique_id');
        $request->validate(['nom' => 'required|string|max:100']);
        Marque::create(['boutique_id' => $bid, 'nom' => $request->nom]);
        return back()->with('ok', 'Marque ajoutée.');
    }

    public function destroy(Marque $marque) {
        $marque->delete();
        return back()->with('ok', 'Marque supprimée.');
    }

    public function create() { return redirect()->route('admin.marques.index'); }
    public function edit(Marque $marque) { return redirect()->route('admin.marques.index'); }
    public function update(Request $request, Marque $marque) {
        $request->validate(['nom' => 'required']);
        $marque->update(['nom' => $request->nom]);
        return back()->with('ok', 'Marque mise à jour.');
    }
    public function show(Marque $marque) { return redirect()->route('admin.marques.index'); }
}