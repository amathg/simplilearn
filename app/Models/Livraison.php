<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Livraison extends Model {
    protected $fillable = ['boutique_id','vente_id','livreur_id','vehicule_id','adresse_livraison','frais_livraison','statut','date_prevue','date_livraison','note'];
    protected $casts = ['date_prevue' => 'datetime', 'date_livraison' => 'datetime'];
    public function boutique() { return $this->belongsTo(Boutique::class); }
    public function vente()    { return $this->belongsTo(Vente::class); }
    public function livreur()  { return $this->belongsTo(Livreur::class); }
    public function vehicule() { return $this->belongsTo(Vehicule::class); }
}