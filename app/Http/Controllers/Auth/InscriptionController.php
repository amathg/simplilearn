<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Boutique;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InscriptionController extends Controller {

    public function index(Request $request) {
        $plans = Plan::where('actif', true)->orderBy('prix_mensuel')->get();
        $plan_slug = $request->get('plan', 'starter');
        return view('inscription', compact('plans', 'plan_slug'));
    }

    public function store(Request $request) {
        $request->validate([
            'nom_boutique' => 'required|string|max:100',
            'email'        => 'required|email|unique:boutiques,email',
            'telephone'    => 'required|string|max:20',
            'login'        => 'required|string|max:50|unique:admins,login',
            'mot_de_passe' => 'required|string|min:6|confirmed',
            'plan_slug'    => 'required|exists:plans,slug',
            'ville'        => 'nullable|string|max:100',
        ]);

        $plan = Plan::where('slug', $request->plan_slug)->first();

        $slug = Str::slug($request->nom_boutique);
        if (Boutique::where('slug', $slug)->exists()) {
            $slug = $slug.'-'.Str::random(4);
        }

        $boutique = Boutique::create([
            'plan_id'   => $plan->id,
            'nom'       => $request->nom_boutique,
            'slug'      => $slug,
            'email'     => $request->email,
            'telephone' => $request->telephone,
            'ville'     => $request->ville,
            'statut'    => 'trial',
            'trial_fin' => now()->addDays(14),
        ]);

        $admin = Admin::create([
            'boutique_id'  => $boutique->id,
            'login'        => $request->login,
            'email'        => $request->email,
            'mot_de_passe' => Hash::make($request->mot_de_passe),
            'role'         => 'owner',
        ]);

        session([
            'admin_id'    => $admin->id,
            'admin_login' => $request->login,
            'admin_role'  => 'owner',
            'boutique_id' => $boutique->id,
            'boutique'    => $boutique->toArray(),
            'plan'        => $plan->toArray(),
        ]);

        return redirect()->route('admin.dashboard');
    }
}