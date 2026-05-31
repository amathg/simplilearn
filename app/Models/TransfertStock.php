<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TransfertStock extends Model {
    protected $table = 'transferts_stock';
    protected $fillable = ['boutique_id','magasin_source_id','magasin_destination_id','reference','statut','notes'];
    public function boutique()     { return $this->belongsTo(Boutique::class); }
    public function source()       { return $this->belongsTo(Magasin::class, 'magasin_source_id'); }
    public function destination()  { return $this->belongsTo(Magasin::class, 'magasin_destination_id'); }
    public function lignes()       { return $this->hasMany(TransfertStockLigne::class, 'transfert_id'); }
}