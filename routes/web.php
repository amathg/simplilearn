<?php
use App\Http\Controllers\Boutique\AuthClientController;
use App\Http\Controllers\Boutique\ProfilController;
use Illuminate\Support\Facades\Route;
use App\Models\Plan;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\InscriptionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProduitController;
use App\Http\Controllers\Admin\VenteController;
use App\Http\Controllers\Admin\FournisseurController;
use App\Http\Controllers\Admin\MarqueController;
use App\Http\Controllers\Admin\MagasinController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\InventaireController;
use App\Http\Controllers\Admin\AchatController;
use App\Http\Controllers\Admin\CaisseController;
use App\Http\Controllers\Admin\AgentIAController;
use App\Http\Controllers\Admin\ComptabiliteController;
use App\Http\Controllers\Admin\DepenseController;
use App\Http\Controllers\Admin\RHController;
use App\Http\Controllers\Admin\FideliteController;
use App\Http\Controllers\Admin\LivraisonController;
use App\Http\Controllers\Admin\SavController;
use App\Http\Controllers\Admin\ReportingController;
use App\Http\Controllers\Admin\ParametreController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Boutique\CatalogueController;
use App\Http\Controllers\Boutique\PanierController;
use App\Http\Controllers\Boutique\CommandeController;

Route::get('/images/{path}', function ($path) {
    $file = storage_path('app/public/' . $path);
    if (!file_exists($file)) abort(404);
    $mime = mime_content_type($file);
    return response()->file($file, ['Content-Type' => $mime]);
})->where('path', '.*');

Route::get('/', function () {
    $plans = Plan::where('actif', true)->orderBy('prix_mensuel')->get();
    return view('welcome', compact('plans'));
})->name('home');

Route::get('/inscription', [InscriptionController::class, 'index'])->name('inscription');
Route::post('/inscription', [InscriptionController::class, 'store'])->name('inscription.store');

Route::get('/admin/login', [LoginController::class, 'index'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'store'])->name('admin.login.store');
Route::post('/admin/logout', [LoginController::class, 'destroy'])->name('admin.logout');

Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('produits', ProduitController::class);
    Route::resource('marques', MarqueController::class);

    Route::get('stocks', [StockController::class, 'index'])->name('stocks.index');
    Route::post('stocks/ajuster', [StockController::class, 'ajuster'])->name('stocks.ajuster');
    Route::get('stocks/mouvements', [StockController::class, 'mouvements'])->name('stocks.mouvements');
    Route::resource('magasins', MagasinController::class);
    Route::get('inventaires-rapport-pdf', [InventaireController::class, 'rapportPdf'])->name('inventaires.pdf');
    Route::resource('inventaires', InventaireController::class);
    Route::post('inventaires/{inventaire}/valider', [InventaireController::class, 'valider'])->name('inventaires.valider');

    Route::resource('fournisseurs', FournisseurController::class);
    Route::resource('achats', AchatController::class);
    Route::post('achats/{achat}/recevoir', [AchatController::class, 'recevoir'])->name('achats.recevoir');

    Route::resource('ventes', VenteController::class)->only(['index','show','update']);
    Route::get('pos', [VenteController::class, 'pos'])->name('ventes.pos');
    Route::post('pos/vendre', [VenteController::class, 'vendre'])->name('ventes.vendre');
    Route::get('credits', [VenteController::class, 'credits'])->name('ventes.credits');
    Route::post('credits/{credit}/payer', [VenteController::class, 'payerCredit'])->name('ventes.credits.payer');

    Route::get('caisse', [CaisseController::class, 'index'])->name('caisse.index');
    Route::post('caisse/ouvrir', [CaisseController::class, 'ouvrir'])->name('caisse.ouvrir');
    Route::post('caisse/fermer', [CaisseController::class, 'fermer'])->name('caisse.fermer');
    Route::get('caisse/historique', [CaisseController::class, 'historique'])->name('caisse.historique');
    Route::get('caisse/stats', [CaisseController::class, 'stats'])->name('caisse.stats');

    Route::get('agent-ia', [AgentIAController::class, 'index'])->name('agent-ia.index');
    Route::post('agent-ia/generer', [AgentIAController::class, 'generer'])->name('agent-ia.generer');
    Route::post('agent-ia/{campagne}/sauvegarder', [AgentIAController::class, 'sauvegarder'])->name('agent-ia.sauvegarder');
    Route::delete('agent-ia/{campagne}', [AgentIAController::class, 'destroy'])->name('agent-ia.destroy');

    Route::get('comptabilite', [ComptabiliteController::class, 'index'])->name('comptabilite.index');
    Route::get('comptabilite/journal', [ComptabiliteController::class, 'journal'])->name('comptabilite.journal');
    Route::get('comptabilite/grand-livre', [ComptabiliteController::class, 'grandLivre'])->name('comptabilite.grand-livre');
    Route::get('comptabilite/balance', [ComptabiliteController::class, 'balance'])->name('comptabilite.balance');
    Route::get('comptabilite/bilan', [ComptabiliteController::class, 'bilan'])->name('comptabilite.bilan');
    Route::resource('comptes', ComptabiliteController::class)->only(['index','store','update','destroy']);

    Route::resource('depenses', DepenseController::class);

    Route::resource('employes', RHController::class);
    Route::get('employes/{employe}/presences', [RHController::class, 'presences'])->name('employes.presences');
    Route::post('employes/{employe}/presences', [RHController::class, 'storePresence'])->name('employes.presences.store');
    Route::get('conges', [RHController::class, 'conges'])->name('conges.index');
    Route::post('conges', [RHController::class, 'storeConge'])->name('conges.store');
    Route::post('conges/{conge}/approuver', [RHController::class, 'approuverConge'])->name('conges.approuver');
    Route::get('paie', [RHController::class, 'paie'])->name('paie.index');
    Route::post('paie/generer', [RHController::class, 'genererFiche'])->name('paie.generer');
    Route::get('avances', [RHController::class, 'avances'])->name('avances.index');
    Route::post('avances', [RHController::class, 'storeAvance'])->name('avances.store');

    Route::get('fidelite', [FideliteController::class, 'index'])->name('fidelite.index');
    Route::resource('clients', FideliteController::class)->only(['index','show']);
    Route::post('fidelite/carte', [FideliteController::class, 'creerCarte'])->name('fidelite.carte');

    Route::resource('livraisons', LivraisonController::class);
    Route::post('livraisons/{livraison}/assigner', [LivraisonController::class, 'assigner'])->name('livraisons.assigner');

    Route::resource('sav', SavController::class);

    Route::get('reporting', [ReportingController::class, 'index'])->name('reporting.index');
    Route::get('reporting/ventes', [ReportingController::class, 'ventes'])->name('reporting.ventes');
    Route::get('reporting/stocks', [ReportingController::class, 'stocks'])->name('reporting.stocks');
    Route::get('reporting/finances', [ReportingController::class, 'finances'])->name('reporting.finances');
    Route::get('reporting/rh', [ReportingController::class, 'rh'])->name('reporting.rh');

    Route::get('parametres', [ParametreController::class, 'index'])->name('parametres.index');
    Route::post('parametres', [ParametreController::class, 'update'])->name('parametres.update');
    Route::post('categories', [ParametreController::class, 'storeCategorie'])->name('categories.store');
    Route::delete('categories/{categorie}', [ParametreController::class, 'destroyCategorie'])->name('categories.destroy');
    Route::resource('roles', RoleController::class);
});

Route::prefix('boutique/{slug}')->name('boutique.')->group(function () {
    Route::get('/', [CatalogueController::class, 'index'])->name('index');
    Route::get('/produit/{id}', [CatalogueController::class, 'show'])->name('produit');
    Route::get('/panier', [PanierController::class, 'index'])->name('panier');
    Route::post('/panier/ajouter', [PanierController::class, 'ajouter'])->name('panier.ajouter');
    Route::get('/panier/maj', [PanierController::class, 'maj'])->name('panier.maj');
    Route::get('/panier/retirer/{id}', [PanierController::class, 'retirer'])->name('panier.retirer');
    Route::get('/commande', [CommandeController::class, 'index'])->name('commande');
    Route::post('/commande', [CommandeController::class, 'store'])->name('commande.store');
    Route::get('/confirmation', [CommandeController::class, 'confirmation'])->name('confirmation');
    Route::get('/connexion', [LoginController::class, 'clientIndex'])->name('connexion');
    Route::post('/connexion', [LoginController::class, 'clientStore'])->name('connexion.store');
    Route::get('/deconnexion', [LoginController::class, 'clientDestroy'])->name('deconnexion');
    Route::get('/mon-compte', [CatalogueController::class, 'monCompte'])->name('mon-compte')->middleware('client.auth');
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil')->middleware('client.auth');
    Route::post('/profil', [ProfilController::class, 'update'])->name('profil.update')->middleware('client.auth');
    Route::post('/profil/password', [ProfilController::class, 'password'])->name('profil.password')->middleware('client.auth');
    Route::get('/inscription', [AuthClientController::class, 'inscriptionForm'])->name('inscription');
    Route::post('/inscription', [AuthClientController::class, 'inscription'])->name('inscription.store');
    Route::get('/mot-de-passe-oublie', [AuthClientController::class, 'oublieForm'])->name('mot-de-passe-oublie');
    Route::post('/mot-de-passe-oublie', [AuthClientController::class, 'oublie'])->name('mot-de-passe-oublie.store');
    Route::get('/reset-password/{token}', [AuthClientController::class, 'resetForm'])->name('reset-password');
    Route::post('/reset-password/{token}', [AuthClientController::class, 'reset'])->name('reset-password.store');
});

Route::prefix('api/v1')->name('api.')->middleware('throttle:60,1')->group(function () {
    Route::get('produits/{slug}', [\App\Http\Controllers\Api\ProduitApiController::class, 'index'])->name('produits');
    Route::get('ventes/{slug}', [\App\Http\Controllers\Api\VenteApiController::class, 'index'])->name('ventes');
    Route::get('stocks/{slug}', [\App\Http\Controllers\Api\StockApiController::class, 'index'])->name('stocks');
});
