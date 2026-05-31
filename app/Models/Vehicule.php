<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model {
    protected $fillable = ['boutique_id','immatriculation','marque','modele','type','actif'];
    protected $casts = ['actif' => 'boolean'];
    public function boutique()   { return $this->belongsTo(Boutique::class); }
    public function livraisons() { return $this->hasMany(Livraison::class); }
}