<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Garantie extends Model {
    protected $fillable = ['boutique_id','vente_id','produit_id','duree_mois','date_debut','date_fin','conditions','actif'];
    protected $casts = ['date_debut' => 'date', 'date_fin' => 'date', 'actif' => 'boolean'];
    public function boutique() { return $this->belongsTo(Boutique::class); }
    public function vente()    { return $this->belongsTo(Vente::class); }
    public function produit()  { return $this->belongsTo(Produit::class); }
    public function isExpire(): bool { return $this->date_fin->isPast(); }
}