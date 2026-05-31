<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vente extends Model {
    protected $fillable = [
        'boutique_id','client_id','reference','statut',
        'total_ht','total_tva','total_ttc',
        'canal','mode_paiement','notes'
    ];

    public function boutique() { return $this->belongsTo(Boutique::class); }
    public function client()   { return $this->belongsTo(Client::class); }
    public function lignes()   { return $this->hasMany(VenteLigne::class); }
}