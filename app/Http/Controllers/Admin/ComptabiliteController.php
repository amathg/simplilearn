<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompteComptable;
use App\Models\EcritureComptable;
use Illuminate\Http\Request;

class ComptabiliteController extends Controller {

    public function index() {
        $bid     = session('boutique_id');
        $comptes = CompteComptable::where('boutique_id', $bid)
            ->orderBy('numero')->get();
        $total_debit  = EcritureComptable::where('boutique_id', $bid)->sum('debit');
        $total_credit = EcritureComptable::where('boutique_id', $bid)->sum('credit');
        return view('admin.comptabilite.index', compact('comptes','total_debit','total_credit'));
    }

    public function journal() {
        $bid       = session('boutique_id');
        $ecritures = EcritureComptable::where('boutique_id', $bid)
            ->with('compte')->latest()->paginate(50);
        return view('admin.comptabilite.journal', compact('ecritures'));
    }

    public function grandLivre() {
        $bid     = session('boutique_id');
        $comptes = CompteComptable::where('boutique_id', $bid)
            ->with('ecritures')->orderBy('numero')->get();
        return view('admin.comptabilite.grand_livre', compact('comptes'));
    }

    public function balance() {
        $bid     = session('boutique_id');
        $comptes = CompteComptable::where('boutique_id', $bid)
            ->with('ecritures')->orderBy('numero')->get();
        return view('admin.comptabilite.balance', compact('comptes'));
    }

    public function bilan() {
        $bid    = session('boutique_id');
        $actifs = CompteComptable::where('boutique_id', $bid)
            ->where('type', 'actif')->with('ecritures')->get();
        $passifs = CompteComptable::where('boutique_id', $bid)
            ->where('type', 'passif')->with('ecritures')->get();
        return view('admin.comptabilite.bilan', compact('actifs','passifs'));
    }

    public function store(Request $request) {
        $bid = session('boutique_id');
        $request->validate(['numero' => 'required', 'libelle' => 'required', 'type' => 'required']);
        CompteComptable::create([...$request->only(['numero','libelle','type','parent_id']), 'boutique_id' => $bid]);
        return back()->with('ok', 'Compte créé.');
    }

    public function update(Request $request, CompteComptable $compte) {
        $compte->update($request->only(['libelle','type','actif']));
        return back()->with('ok', 'Compte mis à jour.');
    }

    public function destroy(CompteComptable $compte) {
        $compte->delete();
        return back()->with('ok', 'Compte supprimé.');
    }

    public function create() { return redirect()->route('admin.comptabilite.index'); }
    public function edit(CompteComptable $compte) { return redirect()->route('admin.comptabilite.index'); }
    public function show(CompteComptable $compte) { return redirect()->route('admin.comptabilite.index'); }
}