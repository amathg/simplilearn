<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenteLigne extends Model {
    protected $table = 'ventes_lignes';
    protected $fillable = [
        'vente_id','produit_id','nom_produit',
        'quantite','prix_unitaire','tva','remise'
    ];

    public function vente()   { return $this->belongsTo(Vente::class); }
    public function produit() { return $this->belongsTo(Produit::class); }

    public function getTotalAttribute(): float {
        return $this->prix_unitaire * $this->quantite;
    }
}