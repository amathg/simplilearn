<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CampagneIA;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AgentIAController extends Controller {

    public function index() {
        $bid       = session('boutique_id');
        $campagnes = CampagneIA::where('boutique_id', $bid)
            ->latest()->paginate(20);

        $stats = [
            'total'     => CampagneIA::where('boutique_id', $bid)->count(),
            'publiees'  => CampagneIA::where('boutique_id', $bid)->where('statut', 'publie')->count(),
            'brouillons'=> CampagneIA::where('boutique_id', $bid)->where('statut', 'brouillon')->count(),
            'programmes'=> CampagneIA::where('boutique_id', $bid)->where('statut', 'programme')->count(),
        ];

        $produits = Produit::where('boutique_id', $bid)
            ->where('visible', true)->take(20)->get();

        return view('admin.agent_ia.index', compact('campagnes', 'stats', 'produits'));
    }

    // Générer le contenu via Claude API
    public function generer(Request $request) {
        $request->validate([
            'reseau'       => 'required|in:instagram,facebook,tiktok,tous',
            'type_contenu' => 'required|in:post,story,video,carousel',
            'prompt'       => 'required|string|min:10',
        ]);

        $bid      = session('boutique_id');
        $boutique = session('boutique.nom', 'Ma Boutique');

        // Construire le prompt enrichi
        $promptComplet = $this->construirePrompt(
            $request->prompt,
            $request->reseau,
            $request->type_contenu,
            $boutique,
            $request->produit_id
        );

        try {
            // Appel à l'API Claude
            $response = Http::withHeaders([
                'x-api-key'         => config('services.anthropic.key'),
                'anthropic-version' => '2023-06-01',
                'content-type'      => 'application/json',
            ])->post('https://api.anthropic.com/v1/messages', [
                'model'      => 'claude-sonnet-4-20250514',
                'max_tokens' => 1024,
                'messages'   => [
                    ['role' => 'user', 'content' => $promptComplet]
                ],
            ]);

            $data    = $response->json();
            $contenu = $data['content'][0]['text'] ?? 'Erreur de génération.';

            // Sauvegarder la campagne
            $campagne = CampagneIA::create([
                'boutique_id'       => $bid,
                'admin_id'          => session('admin_id'),
                'titre'             => 'Campagne ' . ucfirst($request->reseau) . ' — ' . now()->format('d/m/Y'),
                'reseau'            => $request->reseau,
                'type_contenu'      => $request->type_contenu,
                'prompt_utilisateur'=> $request->prompt,
                'contenu_genere'    => $contenu,
                'statut'            => 'brouillon',
            ]);

            return response()->json([
                'success'  => true,
                'contenu'  => $contenu,
                'id'       => $campagne->id,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'   => 'Erreur de génération : ' . $e->getMessage(),
            ], 500);
        }
    }

    // Sauvegarder les modifications manuelles
    public function sauvegarder(Request $request, CampagneIA $campagne) {
        $campagne->update([
            'titre'          => $request->titre,
            'contenu_genere' => $request->contenu,
            'statut'         => $request->statut ?? 'brouillon',
            'programme_at'   => $request->programme_at,
        ]);
        return back()->with('ok', 'Campagne sauvegardée.');
    }

    public function destroy(CampagneIA $campagne) {
        $campagne->delete();
        return back()->with('ok', 'Campagne supprimée.');
    }

    // Construction du prompt selon le réseau et type
    private function construirePrompt(string $prompt, string $reseau, string $type, string $boutique, ?int $produitId): string {
        $produitInfo = '';
        if ($produitId) {
            $produit = Produit::find($produitId);
            if ($produit) {
                $produitInfo = "\nProduit à promouvoir : {$produit->nom} — Prix : {$produit->prix_final} FCFA\nDescription : {$produit->description}";
            }
        }

        $instructions = match($reseau) {
            'instagram' => "Crée un post Instagram accrocheur avec des emojis, des hashtags pertinents (#commerce #afrique etc.) et un appel à l'action fort. Maximum 2200 caractères.",
            'facebook'  => "Rédige un post Facebook engageant, plus détaillé et conversationnel. Inclus un appel à l'action et 3-5 hashtags. Maximum 500 mots.",
            'tiktok'    => "Génère un script TikTok dynamique avec hook d'accroche (3 secondes), contenu principal et appel à l'action. Format : [HOOK] / [CONTENU] / [CTA]. Maximum 60 secondes de lecture.",
            default     => "Crée du contenu publicitaire adapté à Instagram, Facebook et TikTok simultanément. Donne 3 versions séparées.",
        };

        $typeInstr = match($type) {
            'story'    => "Format : contenu vertical pour Story (court, percutant, 15 secondes max).",
            'video'    => "Format : script vidéo avec scènes numérotées.",
            'carousel' => "Format : 5 slides avec titre + texte court pour chaque slide.",
            default    => "Format : post standard.",
        };

        return "Tu es un expert en marketing digital pour les commerçants africains.
Boutique : {$boutique}{$produitInfo}

Demande : {$prompt}

Instructions réseau : {$instructions}
{$typeInstr}

Génère uniquement le contenu publicitaire, prêt à être copié-collé. Pas d'explication supplémentaire.
Utilise un langage proche du public africain francophone, chaleureux et authentique.";
    }
}