<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Boutique;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller {

    // ── ADMIN ────────────────────────────────────────────
    public function index() {
        if (session('admin_id')) return redirect()->route('admin.dashboard');
        return view('admin.login');
    }

    public function store(Request $request) {
        $request->validate([
            'login'        => 'required',
            'mot_de_passe' => 'required',
        ]);

        $admin = Admin::where('login', $request->login)
                      ->where('actif', true)
                      ->first();

        if (!$admin || !Hash::check($request->mot_de_passe, $admin->mot_de_passe)) {
            return back()->withErrors(['login' => 'Identifiants incorrects.']);
        }

        $boutique = Boutique::with('plan')->find($admin->boutique_id);

        session([
            'admin_id'    => $admin->id,
            'admin_login' => $admin->login,
            'admin_role'  => $admin->role,
            'boutique_id' => $boutique->id,
            'boutique'    => $boutique->toArray(),
            'plan'        => $boutique->plan->toArray(),
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function destroy(Request $request) {
        $request->session()->forget(['admin_id','admin_login','admin_role','boutique_id','boutique','plan']);
        return redirect()->route('admin.login');
    }

    // ── CLIENT ───────────────────────────────────────────
    public function clientIndex(Request $request, string $slug) {
        if (session('client_id')) return redirect()->route('boutique.mon-compte', $slug);
        $boutique = Boutique::where('slug', $slug)->firstOrFail();
        return view('boutique.connexion', compact('slug', 'boutique'));
    }

    public function clientStore(Request $request, string $slug) {
        $boutique = Boutique::where('slug', $slug)->firstOrFail();

        // Inscription
        if ($request->inscription) {
            $request->validate([
                'prenom'       => 'required|string',
                'nom'          => 'required|string',
                'email'        => 'required|email',
                'mot_de_passe' => 'required|min:6|confirmed',
            ]);

            $client = Client::create([
                'boutique_id'  => $boutique->id,
                'prenom'       => $request->prenom,
                'nom'          => $request->nom,
                'email'        => $request->email,
                'telephone'    => $request->telephone,
                'mot_de_passe' => Hash::make($request->mot_de_passe),
            ]);
        } else {
            // Connexion
            $request->validate([
                'email'        => 'required|email',
                'mot_de_passe' => 'required',
            ]);

            $client = Client::where('boutique_id', $boutique->id)
                            ->where('email', $request->email)
                            ->where('actif', true)
                            ->first();

            if (!$client || !Hash::check($request->mot_de_passe, $client->mot_de_passe)) {
                return back()->withErrors(['email' => 'Email ou mot de passe incorrect.']);
            }
        }

        session([
            'client_id'       => $client->id,
            'client_boutique' => $boutique->id,
            'client'          => $client->toArray(),
        ]);

        return redirect()->route('boutique.index', $slug);
    }

    public function clientDestroy(string $slug) {
        session()->forget(['client_id','client_boutique','client']);
        return redirect()->route('boutique.index', $slug);
    }
}