<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Depense extends Model {
    protected $fillable = ['boutique_id','categorie_id','libelle','montant','date_depense','mode_paiement','reference','justificatif','notes','admin_id'];
    protected $casts = ['date_depense' => 'date'];
    public function boutique()  { return $this->belongsTo(Boutique::class); }
    public function categorie() { return $this->belongsTo(CategorieDepense::class, 'categorie_id'); }
    public function admin()     { return $this->belongsTo(Admin::class); }
}