<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable {
    protected $fillable = [
        'boutique_id','login','email','mot_de_passe','role','actif'
    ];

    protected $hidden = ['mot_de_passe'];

    protected $casts = ['actif' => 'boolean'];

    public function getAuthPasswordName(): string {
        return 'mot_de_passe';
    }

    public function getAuthPassword(): string {
        return $this->mot_de_passe;
    }

    public function boutique() {
        return $this->belongsTo(Boutique::class);
    }
}