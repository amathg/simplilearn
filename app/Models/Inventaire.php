<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Inventaire extends Model {
    protected $fillable = ['boutique_id','magasin_id','reference','statut','date_inventaire','admin_id','notes'];
    protected $casts = ['date_inventaire' => 'date'];
    public function boutique() { return $this->belongsTo(Boutique::class); }
    public function magasin()  { return $this->belongsTo(Magasin::class); }
    public function lignes()   { return $this->hasMany(InventaireLigne::class); }
}