<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller {

    public function index() {
        $bid = session('boutique_id');
        $fournisseurs = Fournisseur::where('boutique_id', $bid)->latest()->get();
        return view('admin.fournisseurs.index', compact('fournisseurs'));
    }

    public function create() {
        return view('admin.fournisseurs.form');
    }

    public function store(Request $request) {
        $bid = session('boutique_id');
        $request->validate(['nom' => 'required|string|max:200']);
        Fournisseur::create([...$request->only(['nom','email','telephone','adresse','ville','pays','contact_nom','numero_fiscal']), 'boutique_id' => $bid]);
        return redirect()->route('admin.fournisseurs.index')->with('ok', 'Fournisseur créé.');
    }

    public function edit(Fournisseur $fournisseur) {
        return view('admin.fournisseurs.form', compact('fournisseur'));
    }

    public function update(Request $request, Fournisseur $fournisseur) {
        $request->validate(['nom' => 'required|string|max:200']);
        $fournisseur->update($request->only(['nom','email','telephone','adresse','ville','pays','contact_nom','numero_fiscal','actif']));
        return redirect()->route('admin.fournisseurs.index')->with('ok', 'Fournisseur mis à jour.');
    }

    public function destroy(Fournisseur $fournisseur) {
        $fournisseur->delete();
        return redirect()->route('admin.fournisseurs.index')->with('ok', 'Fournisseur supprimé.');
    }

    public function show(Fournisseur $fournisseur) {
        return redirect()->route('admin.fournisseurs.edit', $fournisseur);
    }
}