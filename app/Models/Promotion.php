<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model {
    protected $fillable = ['boutique_id','nom','code','type','valeur','minimum_achat','date_debut','date_fin','utilisations_max','utilisations','actif'];
    protected $casts = ['actif' => 'boolean', 'date_debut' => 'date', 'date_fin' => 'date'];
    public function boutique() { return $this->belongsTo(Boutique::class); }
    public function isValide(): bool {
        if (!$this->actif) return false;
        if ($this->date_debut && now()->lt($this->date_debut)) return false;
        if ($this->date_fin && now()->gt($this->date_fin)) return false;
        if ($this->utilisations_max && $this->utilisations >= $this->utilisations_max) return false;
        return true;
    }
}