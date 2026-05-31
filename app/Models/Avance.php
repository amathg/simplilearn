<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Avance extends Model {
    protected $fillable = ['employe_id','montant','date_avance','type','statut','motif'];
    protected $casts = ['date_avance' => 'date'];
    public function employe() { return $this->belongsTo(Employe::class); }
}