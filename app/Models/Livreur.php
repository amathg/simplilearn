<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Livreur extends Model {
    protected $fillable = ['boutique_id','prenom','nom','telephone','vehicule','zone','actif'];
    protected $casts = ['actif' => 'boolean'];
    public function boutique()   { return $this->belongsTo(Boutique::class); }
    public function livraisons() { return $this->hasMany(Livraison::class); }
    public function getNomCompletAttribute(): string { return $this->prenom.' '.$this->nom; }
}