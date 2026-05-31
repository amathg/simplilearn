<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CarteFidelite extends Model {
    protected $table = 'cartes_fidelite';
    protected $fillable = ['boutique_id','client_id','numero','points','valeur_point','niveau','actif'];
    protected $casts = ['actif' => 'boolean'];
    public function boutique() { return $this->belongsTo(Boutique::class); }
    public function client()   { return $this->belongsTo(Client::class); }
    public function points_historique() { return $this->hasMany(PointFidelite::class, 'carte_id'); }
    public function getValeurTotaleAttribute(): float { return $this->points * $this->valeur_point; }
}