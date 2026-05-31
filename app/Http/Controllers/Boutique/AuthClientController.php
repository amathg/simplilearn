<?php
namespace App\Http\Controllers\Boutique;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class AuthClientController extends Controller {

    // ── INSCRIPTION ──────────────────────────────────────
    public function inscriptionForm(string $slug) {
        $boutique = Boutique::where('slug', $slug)->firstOrFail();
        return view('boutique.inscription', compact('boutique'));
    }

    public function inscription(Request $request, string $slug) {
        $boutique = Boutique::where('slug', $slug)->firstOrFail();
        $request->validate([
            'prenom'   => 'required|string|max:100',
            'nom'      => 'required|string|max:100',
            'email'    => 'required|email|unique:clients,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $client = Client::create([
            'boutique_id' => $boutique->id,
            'prenom'      => $request->prenom,
            'nom'         => $request->nom,
            'email'       => $request->email,
            'telephone'   => $request->telephone,
            'password'    => Hash::make($request->password),
        ]);

        // Connecter automatiquement
        session([
            'client_id'     => $client->id,
            'client.prenom' => $client->prenom,
            'client.nom'    => $client->nom,
            'client.email'  => $client->email,
        ]);

        return redirect()->route('boutique.mon-compte', $slug)
            ->with('ok', 'Bienvenue '.$client->prenom.' ! Votre compte a été créé.');
    }

    // ── MOT DE PASSE OUBLIÉ ───────────────────────────────
    public function oublieForm(string $slug) {
        $boutique = Boutique::where('slug', $slug)->firstOrFail();
        return view('boutique.mot-de-passe-oublie', compact('boutique'));
    }

    public function oublie(Request $request, string $slug) {
        $boutique = Boutique::where('slug', $slug)->firstOrFail();
        $request->validate(['email' => 'required|email']);

        $client = Client::where('boutique_id', $boutique->id)
                    ->where('email', $request->email)->first();

        if (!$client) {
            return back()->withErrors(['email' => 'Aucun compte trouvé avec cet email.']);
        }

        // Générer un token
        $token = Str::random(64);
        $client->update([
            'reset_token'    => $token,
            'reset_token_at' => now(),
        ]);

        // Envoyer email avec lien reset
        $lien = route('boutique.reset-password', [$slug, $token]);

        try {
            Mail::raw(
                "Bonjour {$client->prenom},\n\nCliquez sur ce lien pour réinitialiser votre mot de passe :\n{$lien}\n\nCe lien expire dans 1 heure.\n\n{$boutique->nom}",
                fn($m) => $m->to($client->email)->subject('Réinitialisation mot de passe — '.$boutique->nom)
            );
        } catch (\Exception $e) {}

        return back()->with('ok', 'Un email de réinitialisation a été envoyé.');
    }

    // ── RESET MOT DE PASSE ────────────────────────────────
    public function resetForm(string $slug, string $token) {
        $boutique = Boutique::where('slug', $slug)->firstOrFail();
        $client   = Client::where('reset_token', $token)
                        ->where('reset_token_at', '>=', now()->subHour())
                        ->first();
        if (!$client) return redirect()->route('boutique.connexion', $slug)
                            ->withErrors(['email' => 'Lien invalide ou expiré.']);
        return view('boutique.reset-password', compact('boutique','token'));
    }

    public function reset(Request $request, string $slug, string $token) {
        $boutique = Boutique::where('slug', $slug)->firstOrFail();
        $request->validate(['password' => 'required|min:6|confirmed']);

        $client = Client::where('reset_token', $token)
                    ->where('reset_token_at', '>=', now()->subHour())
                    ->firstOrFail();

        $client->update([
            'password'       => Hash::make($request->password),
            'reset_token'    => null,
            'reset_token_at' => null,
        ]);

        return redirect()->route('boutique.connexion', $slug)
            ->with('ok', 'Mot de passe modifié ! Connectez-vous.');
    }
}