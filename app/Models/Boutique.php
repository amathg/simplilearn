<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boutique extends Model {
    protected $fillable = [
        'plan_id','nom','slug','email','telephone',
        'adresse','ville','pays','devise','logo',
        'couleur_primaire','couleur_secondaire','description',
        'statut','trial_fin','abonnement_debut','abonnement_fin','periodicite'
    ];

    protected $casts = [
        'trial_fin'        => 'date',
        'abonnement_debut' => 'date',
        'abonnement_fin'   => 'date',
    ];

    public function plan()       { return $this->belongsTo(Plan::class); }
    public function admins()     { return $this->hasMany(Admin::class); }
    public function categories() { return $this->hasMany(Categorie::class); }
    public function produits()   { return $this->hasMany(Produit::class); }
    public function clients()    { return $this->hasMany(Client::class); }
    public function ventes()     { return $this->hasMany(Vente::class); }

    public function getLienBoutiqueAttribute(): string {
        return route('boutique.index', $this->slug);
    }

    public function isTrialExpired(): bool {
        return $this->statut === 'trial' && $this->trial_fin?->isPast();
    }
}