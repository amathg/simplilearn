<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Marque extends Model {
    protected $fillable = ['boutique_id','nom','logo'];
    public function boutique()  { return $this->belongsTo(Boutique::class); }
    public function produits()  { return $this->hasMany(Produit::class); }
}