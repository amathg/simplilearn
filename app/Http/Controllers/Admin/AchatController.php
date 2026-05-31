<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FactureFournisseur;
use App\Models\Fournisseur;
use App\Models\Stock;
use App\Models\MouvementStock;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AchatController extends Controller {

    public function index() {
        $bid     = session('boutique_id');
        $achats  = FactureFournisseur::where('boutique_id', $bid)
            ->with('fournisseur')->latest()->get();
        $fournisseurs = Fournisseur::where('boutique_id', $bid)->where('actif', true)->get();
        return view('admin.achats.index', compact('achats','fournisseurs'));
    }

    public function create() {
        $bid          = session('boutique_id');
        $fournisseurs = Fournisseur::where('boutique_id', $bid)->where('actif', true)->get();
        $produits     = \App\Models\Produit::where('boutique_id', $bid)->get();
        return view('admin.achats.form', compact('fournisseurs','produits'));
    }

    public function store(Request $request) {
        $bid = session('boutique_id');
        $request->validate([
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'date_facture'   => 'required|date',
            'montant_ttc'    => 'required|numeric|min:0',
        ]);

        FactureFournisseur::create([
            ...$request->only(['fournisseur_id','numero_facture','date_facture','date_echeance','montant_ht','montant_tva','montant_ttc','notes']),
            'boutique_id' => $bid,
            'reference'   => 'FAC-'.strtoupper(Str::random(8)),
        ]);

        return redirect()->route('admin.achats.index')->with('ok', 'Facture enregistrée.');
    }

    public function show(FactureFournisseur $achat) {
        return view('admin.achats.show', compact('achat'));
    }

    public function recevoir(Request $request, FactureFournisseur $achat) {
        $request->validate(['montant_paye' => 'required|numeric|min:0']);
        $total_paye = $achat->montant_paye + $request->montant_paye;
        $statut = $total_paye >= $achat->montant_ttc ? 'payee' : 'partielle';
        $achat->update(['montant_paye' => $total_paye, 'statut' => $statut]);
        return back()->with('ok', 'Paiement enregistré.');
    }

    public function edit(FactureFournisseur $achat) { return redirect()->route('admin.achats.index'); }
    public function update(Request $request, FactureFournisseur $achat) { return redirect()->route('admin.achats.index'); }
    public function destroy(FactureFournisseur $achat) {
        $achat->delete();
        return back()->with('ok', 'Facture supprimée.');
    }
}