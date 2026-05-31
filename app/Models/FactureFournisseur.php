<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FactureFournisseur extends Model {
    protected $table = 'factures_fournisseurs';
    protected $fillable = ['boutique_id','fournisseur_id','reference','numero_facture','date_facture','date_echeance','montant_ht','montant_tva','montant_ttc','montant_paye','statut','notes'];
    protected $casts = ['date_facture' => 'date', 'date_echeance' => 'date'];
    public function boutique()    { return $this->belongsTo(Boutique::class); }
    public function fournisseur() { return $this->belongsTo(Fournisseur::class); }
    public function getMontantResteAttribute() { return $this->montant_ttc - $this->montant_paye; }
}