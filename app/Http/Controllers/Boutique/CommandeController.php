<?php
namespace App\Http\Controllers\Boutique;

use App\Http\Controllers\Controller;
use App\Models\Boutique;
use App\Models\Client;
use App\Models\Magasin;
use App\Models\Vente;
use App\Models\VenteLigne;
use App\Models\Stock;
use App\Models\Notification;
use App\Mail\CommandeConfirmationClient;
use App\Mail\CommandeNotificationMarchand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CommandeController extends Controller {

    public function index(string $slug) {
        $boutique = Boutique::where('slug', $slug)->firstOrFail();
        $panier   = session('panier_'.$boutique->id, []);
        if (empty($panier)) return redirect()->route('boutique.panier', $slug);
        $total    = collect($panier)->sum(fn($i) => $i['prix'] * $i['quantite']);
        $magasins = Magasin::where('boutique_id', $boutique->id)->where('actif', true)->get();
        return view('boutique.commande', compact('boutique','panier','total','magasins'));
    }

    public function store(Request $request, string $slug) {
        $boutique = Boutique::where('slug', $slug)->firstOrFail();
        $panier   = session('panier_'.$boutique->id, []);
        if (empty($panier)) return redirect()->route('boutique.panier', $slug);

        $request->validate([
            'prenom'       => 'required|string',
            'nom'          => 'required|string',
            'email'        => 'required|email',
            'mode_retrait' => 'required|in:livraison,retrait',
            'magasin_id'   => 'required_if:mode_retrait,retrait|nullable|exists:magasins,id',
        ]);

        $total = collect($panier)->sum(fn($i) => $i['prix'] * $i['quantite']);

        $client = Client::firstOrCreate(
            ['boutique_id' => $boutique->id, 'email' => $request->email],
            [
                'prenom'    => $request->prenom,
                'nom'       => $request->nom,
                'telephone' => $request->telephone,
                'adresse'   => $request->adresse,
            ]
        );

        $vente = Vente::create([
            'boutique_id'   => $boutique->id,
            'client_id'     => $client->id,
            'reference'     => 'CMD-'.strtoupper(Str::random(8)),
            'statut'        => 'en_attente',
            'total_ht'      => $total,
            'total_tva'     => 0,
            'total_ttc'     => $total,
            'canal'         => 'boutique_en_ligne',
            'mode_paiement' => $request->mode_paiement ?? 'sur_place',
            'mode_retrait'  => $request->mode_retrait ?? 'livraison',
            'magasin_id'    => $request->mode_retrait === 'retrait' ? $request->magasin_id : null,
            'notes'         => $request->notes,
        ]);

        foreach ($panier as $pid => $item) {
            VenteLigne::create([
                'vente_id'      => $vente->id,
                'produit_id'    => $pid,
                'nom_produit'   => $item['nom'],
                'quantite'      => $item['quantite'],
                'prix_unitaire' => $item['prix'],
            ]);

            // Décrémenter le stock du magasin choisi ou du stock général
            if ($request->mode_retrait === 'retrait' && $request->magasin_id) {
                Stock::where('produit_id', $pid)
                    ->where('magasin_id', $request->magasin_id)
                    ->decrement('quantite', $item['quantite']);
            } else {
                Stock::where('produit_id', $pid)
                    ->decrement('quantite', $item['quantite']);
            }
        }

        // Notification admin BDD
        try {
            $magasin = $request->mode_retrait === 'retrait'
                ? Magasin::find($request->magasin_id)
                : null;

            $messageRetrait = $magasin
                ? " — Retrait au magasin : {$magasin->nom} ({$magasin->ville})"
                : " — Livraison à domicile";

            Notification::create([
                'boutique_id' => $boutique->id,
                'titre'       => "Nouvelle commande {$vente->reference}",
                'message'     => "{$request->prenom} {$request->nom} — ".number_format($total,0,',',' ')." {$boutique->devise}{$messageRetrait}",
                'type'        => 'commande',
            ]);
        } catch (\Exception $e) {}

        // Email confirmation client
        try {
            $vente->load(['client','lignes']);
            Mail::to($client->email)
                ->send(new CommandeConfirmationClient($vente, $boutique));
        } catch (\Exception $e) {}

        // Email notification marchand
        try {
            if ($boutique->email) {
                Mail::to($boutique->email)
                    ->send(new CommandeNotificationMarchand($vente, $boutique));
            }
        } catch (\Exception $e) {}

        // Vider le panier
        session()->forget('panier_'.$boutique->id);
        session(['last_vente_id_'.$boutique->id => $vente->id]);

        return redirect()->route('boutique.confirmation', $slug);
    }

    public function confirmation(string $slug) {
        $boutique = Boutique::where('slug', $slug)->firstOrFail();
        $vente_id = session('last_vente_id_'.$boutique->id);
        if (!$vente_id) return redirect()->route('boutique.index', $slug);
        $vente = Vente::with(['magasin'])->findOrFail($vente_id);
        return view('boutique.confirmation', compact('boutique','vente'));
    }
}