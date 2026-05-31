<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ParametreController extends Controller {

    public function index() {
        $bid      = session('boutique_id');
        $boutique = Boutique::with('plan')->findOrFail($bid);
        return view('admin.parametres.index', compact('boutique'));
    }

    public function update(Request $request) {
        $bid      = session('boutique_id');
        $boutique = Boutique::findOrFail($bid);

        $request->validate([
            'nom'       => 'required|string|max:100',
            'telephone' => 'nullable|string',
            'ville'     => 'nullable|string',
            'devise'    => 'nullable|string',
        ]);

        $logo = $boutique->logo;
        if ($request->hasFile('logo')) {
            if ($logo) Storage::disk('public')->delete($logo);
            $logo = $request->file('logo')->store('logos', 'public');
        }

        $boutique->update([
            ...$request->only(['nom','email','telephone','adresse','ville','pays','devise','description','couleur_primaire','couleur_secondaire']),
            'logo' => $logo,
        ]);

        // Mettre à jour la session
        session(['boutique' => $boutique->fresh()->toArray()]);

        return back()->with('ok', 'Paramètres mis à jour.');
    }
}