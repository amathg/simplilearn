<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Depense;
use App\Models\CategorieDepense;
use Illuminate\Http\Request;

class DepenseController extends Controller {

    public function index() {
        $bid       = session('boutique_id');
        $depenses  = Depense::where('boutique_id', $bid)
            ->with('categorie')->latest()->get();
        $categories = CategorieDepense::where('boutique_id', $bid)->get();
        $total_mois = Depense::where('boutique_id', $bid)
            ->whereMonth('date_depense', now()->month)->sum('montant');
        return view('admin.depenses.index', compact('depenses','categories','total_mois'));
    }

    public function store(Request $request) {
        $bid = session('boutique_id');
        $request->validate([
            'libelle'      => 'required|string',
            'montant'      => 'required|numeric|min:0',
            'date_depense' => 'required|date',
        ]);
        Depense::create([...$request->only(['libelle','montant','date_depense','mode_paiement','categorie_id','reference','notes']), 'boutique_id' => $bid, 'admin_id' => session('admin_id')]);
        return back()->with('ok', 'Dépense enregistrée.');
    }

    public function destroy(Depense $depense) {
        $depense->delete();
        return back()->with('ok', 'Dépense supprimée.');
    }

    public function create() { return redirect()->route('admin.depenses.index'); }
    public function edit(Depense $depense) { return redirect()->route('admin.depenses.index'); }
    public function update(Request $request, Depense $depense) { return redirect()->route('admin.depenses.index'); }
    public function show(Depense $depense) { return redirect()->route('admin.depenses.index'); }
}