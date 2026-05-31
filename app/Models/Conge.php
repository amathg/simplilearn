<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Conge extends Model {
    protected $fillable = ['employe_id','date_debut','date_fin','nb_jours','type','statut','motif'];
    protected $casts = ['date_debut' => 'date', 'date_fin' => 'date'];
    public function employe() { return $this->belongsTo(Employe::class); }
}