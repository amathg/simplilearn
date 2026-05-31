<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model {
    protected $fillable = [
        'boutique_id','prenom','nom','email',
        'telephone','adresse','mot_de_passe','actif'
    ];

    protected $hidden  = ['mot_de_passe'];
    protected $casts   = ['actif' => 'boolean'];

    public function boutique() { return $this->belongsTo(Boutique::class); }
    public function ventes()   { return $this->hasMany(Vente::class); }

    public function getNomCompletAttribute(): string {
        return $this->prenom.' '.$this->nom;
    }
}