<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class InventaireLigne extends Model {
    protected $fillable = ['inventaire_id','produit_id','stock_theorique','stock_reel','ecart'];
    public function inventaire() { return $this->belongsTo(Inventaire::class); }
    public function produit()    { return $this->belongsTo(Produit::class); }
}