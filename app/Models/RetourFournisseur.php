<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class RetourFournisseur extends Model {
    protected $table = 'retours_fournisseurs';
    protected $fillable = ['boutique_id','fournisseur_id','reference','date_retour','motif','montant_total','statut','notes'];
    protected $casts = ['date_retour' => 'date'];
    public function boutique()    { return $this->belongsTo(Boutique::class); }
    public function fournisseur() { return $this->belongsTo(Fournisseur::class); }
    public function lignes()      { return $this->hasMany(RetourFournisseurLigne::class, 'retour_id'); }
}