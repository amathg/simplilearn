<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vente;
use App\Models\Produit;
use App\Models\Client;
use App\Models\Depense;
use App\Models\Employe;
use Illuminate\Http\Request;

class ReportingController extends Controller {

    public function index() {
        $bid    = session('boutique_id');
        $devise = session('boutique.devise', 'FCFA');

        // CA par mois (12 derniers mois)
        $ca_mois = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $ca_mois[] = [
                'mois' => $date->format('M Y'),
                'ca'   => Vente::where('boutique_id', $bid)
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->where('statut', '!=', 'annulee')
                    ->sum('total_ttc'),
            ];
        }

        $stats = [
            'ca_total'       => Vente::where('boutique_id', $bid)->where('statut', '!=', 'annulee')->sum('total_ttc'),
            'ca_mois'        => Vente::where('boutique_id', $bid)->whereMonth('created_at', now()->month)->sum('total_ttc'),
            'nb_ventes'      => Vente::where('boutique_id', $bid)->count(),
            'nb_clients'     => Client::where('boutique_id', $bid)->count(),
            'nb_produits'    => Produit::where('boutique_id', $bid)->count(),
            'depenses_mois'  => Depense::where('boutique_id', $bid)->whereMonth('date_depense', now()->month)->sum('montant'),
            'nb_employes'    => Employe::where('boutique_id', $bid)->where('actif', true)->count(),
        ];

        $top_produits = Produit::where('boutique_id', $bid)
            ->withCount('stock')
            ->take(10)->get();

        return view('admin.reporting.index', compact('stats','ca_mois','top_produits','devise'));
    }

    public function ventes() {
        $bid    = session('boutique_id');
        $devise = session('boutique.devise', 'FCFA');
        $ventes = Vente::where('boutique_id', $bid)
            ->with('client')
            ->latest()->paginate(50);
        return view('admin.reporting.ventes', compact('ventes','devise'));
    }

    public function stocks() {
        $bid     = session('boutique_id');
        $produits = Produit::where('boutique_id', $bid)
            ->with(['stock','categorie'])
            ->get();
        return view('admin.reporting.stocks', compact('produits'));
    }

    public function finances() {
        $bid    = session('boutique_id');
        $devise = session('boutique.devise', 'FCFA');
        $depenses_par_cat = Depense::where('boutique_id', $bid)
            ->with('categorie')
            ->whereMonth('date_depense', now()->month)
            ->get()
            ->groupBy('categorie.nom');
        $ca_mois = Vente::where('boutique_id', $bid)
            ->whereMonth('created_at', now()->month)
            ->sum('total_ttc');
        $depenses_mois = Depense::where('boutique_id', $bid)
            ->whereMonth('date_depense', now()->month)
            ->sum('montant');
        $benefice = $ca_mois - $depenses_mois;
        return view('admin.reporting.finances', compact('depenses_par_cat','ca_mois','depenses_mois','benefice','devise'));
    }

    public function rh() {
        $bid      = session('boutique_id');
        $employes = Employe::where('boutique_id', $bid)->with(['fiches_paie','avances'])->get();
        $masse_salariale = $employes->sum('salaire_base');
        return view('admin.reporting.rh', compact('employes','masse_salariale'));
    }
}