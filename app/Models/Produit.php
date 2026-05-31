<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model {
    protected $fillable = [
        'boutique_id','categorie_id','nom','description',
        'prix_vente','prix_achat','promo','stock_alerte',
        'icone','image','nouveau','visible'
    ];

    protected $casts = [
        'nouveau' => 'boolean',
        'visible' => 'boolean',
    ];

    public function boutique()  { return $this->belongsTo(Boutique::class); }
    public function categorie() { return $this->belongsTo(Categorie::class); }
    public function stock()     { return $this->hasOne(Stock::class); }

    public function getPrixFinalAttribute(): float {
        if ($this->promo > 0)
            return $this->prix_vente * (1 - $this->promo / 100);
        return $this->prix_vente;
    }

    public function getStockDispoAttribute(): int {
        return $this->stock?->quantite ?? 0;
    }
}