<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class EcritureComptable extends Model {
    protected $table = 'ecritures_comptables';
    protected $fillable = ['boutique_id','compte_id','journal','date_ecriture','libelle','debit','credit','reference','lettree'];
    protected $casts = ['date_ecriture' => 'date', 'lettree' => 'boolean'];
    public function boutique() { return $this->belongsTo(Boutique::class); }
    public function compte()   { return $this->belongsTo(CompteComptable::class, 'compte_id'); }
}