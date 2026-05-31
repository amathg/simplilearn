<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Magasin extends Model {
    protected $fillable = ['boutique_id','nom','adresse','ville','telephone','principal','actif'];
    protected $casts = ['principal' => 'boolean', 'actif' => 'boolean'];
    public function boutique()    { return $this->belongsTo(Boutique::class); }
    public function stocks()      { return $this->hasMany(Stock::class); }
    public function sessions()    { return $this->hasMany(SessionCaisse::class); }
    public function transferts_source() { return $this->hasMany(TransfertStock::class, 'magasin_source_id'); }
    public function transferts_dest()   { return $this->hasMany(TransfertStock::class, 'magasin_destination_id'); }
}