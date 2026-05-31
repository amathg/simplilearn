<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Employe extends Model {
    protected $fillable = ['boutique_id','matricule','prenom','nom','email','telephone','poste','salaire_base','date_embauche','type_contrat','conges_acquis','conges_pris','actif'];
    protected $casts = ['date_embauche' => 'date', 'actif' => 'boolean'];
    public function boutique()   { return $this->belongsTo(Boutique::class); }
    public function presences()  { return $this->hasMany(Presence::class); }
    public function conges()     { return $this->hasMany(Conge::class); }
    public function fiches_paie(){ return $this->hasMany(FichePaie::class); }
    public function avances()    { return $this->hasMany(Avance::class); }
    public function getNomCompletAttribute(): string { return $this->prenom.' '.$this->nom; }
    public function getCongesSoldeAttribute(): int { return $this->conges_acquis - $this->conges_pris; }
}