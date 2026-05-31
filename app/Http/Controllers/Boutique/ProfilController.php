<?php
namespace App\Http\Controllers\Boutique;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller {

    public function index(string $slug) {
        $boutique = Boutique::where('slug', $slug)->firstOrFail();
        $client   = Client::findOrFail(session('client_id'));
        return view('boutique.profil', compact('boutique','client'));
    }

    public function update(Request $request, string $slug) {
        $boutique = Boutique::where('slug', $slug)->firstOrFail();
        $client   = Client::findOrFail(session('client_id'));

        $request->validate([
            'prenom'    => 'required|string|max:100',
            'nom'       => 'required|string|max:100',
            'email'     => 'required|email|unique:clients,email,'.$client->id,
            'telephone' => 'nullable|string|max:20',
            'adresse'   => 'nullable|string|max:255',
        ]);

        $client->update($request->only(['prenom','nom','email','telephone','adresse']));

        // Mettre à jour la session
        session(['client.prenom' => $client->prenom]);
        session(['client.nom'    => $client->nom]);
        session(['client.email'  => $client->email]);

        return back()->with('ok', 'Profil mis à jour avec succès.');
    }

    public function password(Request $request, string $slug) {
        $boutique = Boutique::where('slug', $slug)->firstOrFail();
        $client   = Client::findOrFail(session('client_id'));

        $request->validate([
            'password_actuel'    => 'required',
            'password'           => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->password_actuel, $client->password)) {
            return back()->withErrors(['password_actuel' => 'Mot de passe actuel incorrect.']);
        }

        $client->update(['password' => Hash::make($request->password)]);
        return back()->with('ok', 'Mot de passe modifié avec succès.');
    }
}