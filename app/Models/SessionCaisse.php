<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SessionCaisse extends Model {
    protected $table = 'sessions_caisse';
    protected $fillable = ['boutique_id','magasin_id','admin_id','ouverture_at','fermeture_at','fond_ouverture','fond_fermeture','total_especes','total_carte','total_mobile','total_credit','total_ventes','statut','notes'];
    protected $casts = ['ouverture_at' => 'datetime', 'fermeture_at' => 'datetime'];
    public function boutique() { return $this->belongsTo(Boutique::class); }
    public function magasin()  { return $this->belongsTo(Magasin::class); }
    public function admin()    { return $this->belongsTo(Admin::class); }
}