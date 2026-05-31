<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MouvementStock extends Model {
    protected $table = 'mouvements_stock';
    protected $fillable = ['boutique_id','produit_id','magasin_id','type','quantite','stock_avant','stock_apres','motif','reference','admin_id'];
    public function produit()  { return $this->belongsTo(Produit::class); }
    public function magasin()  { return $this->belongsTo(Magasin::class); }
    public function admin()    { return $this->belongsTo(Admin::class); }
}