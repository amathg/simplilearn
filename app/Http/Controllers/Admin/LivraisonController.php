<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Livraison;
use App\Models\Livreur;
use App\Models\Vehicule;
use App\Models\Vente;
use Illuminate\Http\Request;

class LivraisonController extends Controller {

    public function index() {
        $bid        = session('boutique_id');
        $livraisons = Livraison::where('boutique_id', $bid)
            ->with(['vente.client','livreur'])->latest()->get();
        $livreurs   = Livreur::where('boutique_id', $bid)->where('actif', true)->get();
        $vehicules  = Vehicule::where('boutique_id', $bid)->where('actif', true)->get();
        return view('admin.livraisons.index', compact('livraisons','livreurs','vehicules'));
    }

    public function store(Request $request) {
        $bid = session('boutique_id');
        $request->validate(['vente_id' => 'required|exists:ventes,id']);
        $vente = Vente::findOrFail($request->vente_id);
        Livraison::create([
            'boutique_id'      => $bid,
            'vente_id'         => $vente->id,
            'adresse_livraison'=> $request->adresse ?? $vente->client?->adresse ?? '',
            'frais_livraison'  => $request->frais_livraison ?? 0,
            'statut'           => 'en_attente',
        ]);
        return back()->with('ok', 'Livraison créée.');
    }

    public function assigner(Request $request, Livraison $livraison) {
        $livraison->update([
            'livreur_id'  => $request->livreur_id,
            'vehicule_id' => $request->vehicule_id,
            'statut'      => 'assignee',
        ]);
        return back()->with('ok', 'Livraison assignée.');
    }

    public function update(Request $request, Livraison $livraison) {
        $livraison->update(['statut' => $request->statut]);
        if ($request->statut === 'livree') {
            $livraison->update(['date_livraison' => now()]);
        }
        return back()->with('ok', 'Statut mis à jour.');
    }

    public function show(Livraison $livraison) { return redirect()->route('admin.livraisons.index'); }
    public function create() { return redirect()->route('admin.livraisons.index'); }
    public function edit(Livraison $livraison) { return redirect()->route('admin.livraisons.index'); }
    public function destroy(Livraison $livraison) {
        $livraison->delete();
        return back()->with('ok', 'Livraison supprimée.');
    }
}