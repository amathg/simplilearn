<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class VenteCredit extends Model {
    protected $table = 'ventes_credit';
    protected $fillable = ['boutique_id','vente_id','client_id','montant_total','montant_paye','montant_restant','date_echeance','statut','notes'];
    protected $casts = ['date_echeance' => 'date'];
    public function boutique()   { return $this->belongsTo(Boutique::class); }
    public function vente()      { return $this->belongsTo(Vente::class); }
    public function client()     { return $this->belongsTo(Client::class); }
    public function paiements()  { return $this->hasMany(PaiementCredit::class); }
}