<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Sav extends Model {
    protected $table = 'sav';
    protected $fillable = ['boutique_id','client_id','vente_id','reference','type','produit_concerne','description','montant_avoir','statut','date_garantie_fin'];
    protected $casts = ['date_garantie_fin' => 'date'];
    public function boutique() { return $this->belongsTo(Boutique::class); }
    public function client()   { return $this->belongsTo(Client::class); }
    public function vente()    { return $this->belongsTo(Vente::class); }
}