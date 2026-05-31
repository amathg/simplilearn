<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model {
    protected $fillable = [
        'nom','slug','prix_mensuel','prix_annuel',
        'nb_produits','nb_employes','nb_magasins',
        'ecommerce','comptabilite','rh','multi_depot',
        'api_access','actif','description'
    ];

    protected $casts = [
        'ecommerce'    => 'boolean',
        'comptabilite' => 'boolean',
        'rh'           => 'boolean',
        'multi_depot'  => 'boolean',
        'api_access'   => 'boolean',
        'actif'        => 'boolean',
    ];

    public function boutiques() {
        return $this->hasMany(Boutique::class);
    }
}