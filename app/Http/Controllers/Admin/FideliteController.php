<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\CarteFidelite;
use Illuminate\Http\Request;

class FideliteController extends Controller {

    public function index() {
        $bid    = session('boutique_id');
        $cartes = CarteFidelite::where('boutique_id', $bid)
            ->with('client')->latest()->get();
        $clients = Client::where('boutique_id', $bid)->get();
        return view('admin.fidelite.index', compact('cartes','clients'));
    }

    public function show(Client $client) {
        $client->load(['ventes','cartes_fidelite']);
        return view('admin.fidelite.show', compact('client'));
    }

    public function creerCarte(Request $request) {
        $bid = session('boutique_id');
        $request->validate(['client_id' => 'required|exists:clients,id']);
        CarteFidelite::firstOrCreate(
            ['boutique_id' => $bid, 'client_id' => $request->client_id],
            ['numero' => 'CARD-'.strtoupper(\Illuminate\Support\Str::random(8)), 'points' => 0]
        );
        return back()->with('ok', 'Carte de fidélité créée.');
    }

    public function create() { return redirect()->route('admin.fidelite.index'); }
    public function store(Request $request) { return redirect()->route('admin.fidelite.index'); }
    public function edit(Client $client) { return redirect()->route('admin.fidelite.index'); }
    public function update(Request $request, Client $client) { return redirect()->route('admin.fidelite.index'); }
    public function destroy(Client $client) { return redirect()->route('admin.fidelite.index'); }
}