<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PaiementCredit extends Model {
    protected $table = 'paiements_credit';
    protected $fillable = ['vente_credit_id','montant','mode_paiement','date_paiement','notes'];
    protected $casts = ['date_paiement' => 'date'];
    public function venteCredit() { return $this->belongsTo(VenteCredit::class); }
}