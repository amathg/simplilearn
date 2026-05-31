<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sav;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SavController extends Controller {

    public function index() {
        $bid  = session('boutique_id');
        $savs = Sav::where('boutique_id', $bid)
            ->with(['client','vente'])->latest()->get();
        $clients = Client::where('boutique_id', $bid)->get();
        return view('admin.sav.index', compact('savs','clients'));
    }

    public function store(Request $request) {
        $bid = session('boutique_id');
        $request->validate([
            'type'             => 'required',
            'produit_concerne' => 'required|string',
            'description'      => 'required|string',
        ]);
        Sav::create([
            ...$request->only(['client_id','vente_id','type','produit_concerne','description','montant_avoir']),
            'boutique_id' => $bid,
            'reference'   => 'SAV-'.strtoupper(Str::random(6)),
            'statut'      => 'ouvert',
        ]);
        return back()->with('ok', 'Dossier SAV créé.');
    }

    public function update(Request $request, Sav $sav) {
        $sav->update(['statut' => $request->statut]);
        return back()->with('ok', 'Statut mis à jour.');
    }

    public function destroy(Sav $sav) {
        $sav->delete();
        return back()->with('ok', 'Dossier supprimé.');
    }

    public function create() { return redirect()->route('admin.sav.index'); }
    public function edit(Sav $sav) { return redirect()->route('admin.sav.index'); }
    public function show(Sav $sav) { return redirect()->route('admin.sav.index'); }
}