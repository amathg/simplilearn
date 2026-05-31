<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employe;
use App\Models\Presence;
use App\Models\Conge;
use App\Models\FichePaie;
use App\Models\Avance;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RHController extends Controller {

    public function index() {
        $bid      = session('boutique_id');
        $employes = Employe::where('boutique_id', $bid)->latest()->get();
        return view('admin.rh.index', compact('employes'));
    }

    public function create() {
        return view('admin.rh.form');
    }

    public function store(Request $request) {
        $bid = session('boutique_id');
        $request->validate([
            'prenom'       => 'required|string',
            'nom'          => 'required|string',
            'poste'        => 'required|string',
            'salaire_base' => 'required|numeric|min:0',
            'date_embauche'=> 'required|date',
        ]);

        Employe::create([
            ...$request->only(['prenom','nom','email','telephone','poste','salaire_base','date_embauche','type_contrat']),
            'boutique_id' => $bid,
            'matricule'   => 'EMP-'.strtoupper(Str::random(6)),
        ]);

        return redirect()->route('admin.employes.index')->with('ok', 'Employé ajouté.');
    }

    public function show(Employe $employe) {
        $employe->load(['presences','conges','fiches_paie','avances']);
        return view('admin.rh.show', compact('employe'));
    }

    public function edit(Employe $employe) {
        return view('admin.rh.form', compact('employe'));
    }

    public function update(Request $request, Employe $employe) {
        $employe->update($request->only(['prenom','nom','email','telephone','poste','salaire_base','type_contrat','actif']));
        return redirect()->route('admin.employes.index')->with('ok', 'Employé mis à jour.');
    }

    public function destroy(Employe $employe) {
        $employe->update(['actif' => false]);
        return redirect()->route('admin.employes.index')->with('ok', 'Employé désactivé.');
    }

    public function presences(Employe $employe) {
        $presences = $employe->presences()->latest()->take(30)->get();
        return view('admin.rh.presences', compact('employe','presences'));
    }

    public function storePresence(Request $request, Employe $employe) {
        $request->validate(['date' => 'required|date', 'statut' => 'required']);
        Presence::updateOrCreate(
            ['employe_id' => $employe->id, 'date' => $request->date],
            $request->only(['statut','heure_arrivee','heure_depart','notes'])
        );
        return back()->with('ok', 'Présence enregistrée.');
    }

    public function conges() {
        $bid    = session('boutique_id');
        $conges = Conge::whereHas('employe', fn($q) => $q->where('boutique_id', $bid))
            ->with('employe')->latest()->get();
        return view('admin.rh.conges', compact('conges'));
    }

    public function storeConge(Request $request) {
        $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'date_debut' => 'required|date',
            'date_fin'   => 'required|date|after_or_equal:date_debut',
            'type'       => 'required',
        ]);
        $nb = \Carbon\Carbon::parse($request->date_debut)->diffInDays($request->date_fin) + 1;
        Conge::create([...$request->only(['employe_id','date_debut','date_fin','type','motif']), 'nb_jours' => $nb]);
        return back()->with('ok', 'Congé enregistré.');
    }

    public function approuverConge(Conge $conge) {
        $conge->update(['statut' => 'approuve']);
        $conge->employe->increment('conges_pris', $conge->nb_jours);
        return back()->with('ok', 'Congé approuvé.');
    }

    public function paie() {
        $bid    = session('boutique_id');
        $employes = Employe::where('boutique_id', $bid)->where('actif', true)->get();
        $fiches   = FichePaie::whereHas('employe', fn($q) => $q->where('boutique_id', $bid))
            ->with('employe')->latest()->take(50)->get();
        return view('admin.rh.paie', compact('employes','fiches'));
    }

    public function genererFiche(Request $request) {
        $request->validate(['employe_id' => 'required|exists:employes,id', 'mois' => 'required|integer', 'annee' => 'required|integer']);
        $employe = Employe::findOrFail($request->employe_id);
        $avances = Avance::where('employe_id', $employe->id)
            ->where('statut', 'approuve')->sum('montant');
        $net = $employe->salaire_base + ($request->primes ?? 0) + ($request->heures_sup ?? 0) - $avances - ($request->cotisations ?? 0);
        FichePaie::create([
            'employe_id'      => $employe->id,
            'mois'            => $request->mois,
            'annee'           => $request->annee,
            'salaire_base'    => $employe->salaire_base,
            'primes'          => $request->primes ?? 0,
            'heures_sup'      => $request->heures_sup ?? 0,
            'avances_deduites'=> $avances,
            'cotisations'     => $request->cotisations ?? 0,
            'net_a_payer'     => max(0, $net),
        ]);
        return back()->with('ok', 'Fiche de paie générée.');
    }

    public function avances() {
        $bid     = session('boutique_id');
        $employes = Employe::where('boutique_id', $bid)->where('actif', true)->get();
        $avances  = Avance::whereHas('employe', fn($q) => $q->where('boutique_id', $bid))
            ->with('employe')->latest()->get();
        return view('admin.rh.avances', compact('employes','avances'));
    }

    public function storeAvance(Request $request) {
        $request->validate([
            'employe_id'  => 'required|exists:employes,id',
            'montant'     => 'required|numeric|min:0',
            'date_avance' => 'required|date',
            'type'        => 'required',
        ]);
        Avance::create($request->only(['employe_id','montant','date_avance','type','motif']));
        return back()->with('ok', 'Avance enregistrée.');
    }
}