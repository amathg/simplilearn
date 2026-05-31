<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PointFidelite extends Model {
    protected $table = 'points_fidelite';
    protected $fillable = ['carte_id','points','type','reference','notes'];
    public function carte() { return $this->belongsTo(CarteFidelite::class); }
}