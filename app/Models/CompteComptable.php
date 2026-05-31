<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CompteComptable extends Model {
    protected $table = 'comptes_comptables';
    protected $fillable = ['boutique_id','numero','libelle','type','parent_id','actif'];
    protected $casts = ['actif' => 'boolean'];
    public function boutique()   { return $this->belongsTo(Boutique::class); }
    public function parent()     { return $this->belongsTo(CompteComptable::class, 'parent_id'); }
    public function enfants()    { return $this->hasMany(CompteComptable::class, 'parent_id'); }
    public function ecritures()  { return $this->hasMany(EcritureComptable::class, 'compte_id'); }
    public function getSoldeAttribute(): float {
        return $this->ecritures->sum('debit') - $this->ecritures->sum('credit');
    }
}