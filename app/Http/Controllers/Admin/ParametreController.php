<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ParametreController extends Controller
{
    public function index()
    {
        $boutique = Boutique::with(['plan', 'categories'])
            ->find(session('boutique_id'));
        $categories = $boutique->categories;
        return view('admin.parametres.parametres_index', compact('boutique', 'categories'));
    }

    public function update(Request $request)
    {
        $boutique = Boutique::find(session('boutique_id'));
        $data = $request->only(['nom','email','telephone','ville','adresse','description','devise','pays','couleur_primaire','couleur_secondaire']);
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }
        $boutique->update($data);
        return back()->with('ok', 'Paramètres enregistrés !');
    }
}
