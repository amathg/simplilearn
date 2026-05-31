<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SessionCaisse;
use App\Models\Vente;
use Illuminate\Http\Request;

class CaisseController extends Controller {

    public function index() {
        $bid     = session('boutique_id');
        $session = SessionCaisse::where('boutique_id', $bid)
            ->where('statut', 'ouverte')
            ->latest()->first();
        return view('admin.caisse.index', compact('session'));
    }

    public function ouvrir(Request $request) {
        $bid = session('boutique_id');
        $request->validate(['fond_ouverture' => 'required|numeric|min:0']);

        // Vérifier qu'il n'y a pas déjà une session ouverte
        $existe = SessionCaisse::where('boutique_id', $bid)
            ->where('statut', 'ouverte')->exists();

        if ($existe) return back()->withErrors(['session' => 'Une session est déjà ouverte.']);

        SessionCaisse::create([
            'boutique_id'   => $bid,
            'admin_id'      => session('admin_id'),
            'ouverture_at'  => now(),
            'fond_ouverture'=> $request->fond_ouverture,
            'statut'        => 'ouverte',
        ]);

        return back()->with('ok', 'Caisse ouverte.');
    }

    public function fermer(Request $request) {
        $bid     = session('boutique_id');
        $session = SessionCaisse::where('boutique_id', $bid)
            ->where('statut', 'ouverte')->latest()->firstOrFail();

        // Calculer les totaux
        $ventes = Vente::where('boutique_id', $bid)
            ->where('created_at', '>=', $session->ouverture_at)
            ->get();

        $session->update([
            'fermeture_at'  => now(),
            'fond_fermeture'=> $request->fond_fermeture ?? 0,
            'total_especes' => $ventes->where('mode_paiement', 'sur_place')->sum('total_ttc'),
            'total_carte'   => $ventes->where('mode_paiement', 'carte')->sum('total_ttc'),
            'total_mobile'  => $ventes->whereIn('mode_paiement', ['orange_money','wero'])->sum('total_ttc'),
            'total_ventes'  => $ventes->sum('total_ttc'),
            'statut'        => 'fermee',
            'notes'         => $request->notes,
        ]);

        return back()->with('ok', 'Caisse fermée avec succès.');
    }

    public function historique() {
        $bid      = session('boutique_id');
        $sessions = SessionCaisse::where('boutique_id', $bid)
            ->with('admin')->latest()->paginate(20);
        return view('admin.caisse.historique', compact('sessions'));
    }
}