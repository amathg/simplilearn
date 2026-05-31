<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model {
    protected $fillable = ['boutique_id','nom','email','telephone','adresse','ville','pays','contact_nom','numero_fiscal','actif'];
    protected $casts = ['actif' => 'boolean'];
    public function boutique()  { return $this->belongsTo(Boutique::class); }
    public function factures()  { return $this->hasMany(FactureFournisseur::class); }
    public function retours()   { return $this->hasMany(RetourFournisseur::class); }
    public function produits()  { return $this->hasMany(Produit::class); }
}