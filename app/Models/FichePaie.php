<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FichePaie extends Model {
    protected $table = 'fiches_paie';
    protected $fillable = ['employe_id','mois','annee','salaire_base','primes','heures_sup','avances_deduites','cotisations','net_a_payer','statut','date_paiement'];
    protected $casts = ['date_paiement' => 'date'];
    public function employe() { return $this->belongsTo(Employe::class); }
}