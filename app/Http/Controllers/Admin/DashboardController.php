<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vente;
use App\Models\Produit;
use App\Models\Client;

class DashboardController extends Controller {

    public function index() {
        $bid = session('boutique_id');

        $stats = [
            'commandes_attente' => Vente::where('boutique_id', $bid)->where('statut', 'en_attente')->count(),
            'commandes_mois'    => Vente::where('boutique_id', $bid)->whereMonth('created_at', now()->month)->count(),
            'ca_mois'           => Vente::where('boutique_id', $bid)->whereMonth('created_at', now()->month)->where('statut', '!=', 'annulee')->sum('total_ttc'),
            'ca_total'          => Vente::where('boutique_id', $bid)->where('statut', '!=', 'annulee')->sum('total_ttc'),
            'nb_clients'        => Client::where('boutique_id', $bid)->count(),
            'nb_ruptures'       => Produit::where('boutique_id', $bid)->whereHas('stock', fn($q) => $q->where('quantite', 0))->count(),
        ];

        $dernieres_ventes = Vente::where('boutique_id', $bid)
            ->with('client')
            ->latest()
            ->take(8)
            ->get();

        $alertes_stock = Produit::where('boutique_id', $bid)
            ->where('visible', true)
            ->whereHas('stock', fn($q) => $q->where('quantite', '<=', 3))
            ->with('stock')
            ->take(6)
            ->get();

        return view('admin.dashboard', compact('stats', 'dernieres_ventes', 'alertes_stock'));
    }
}