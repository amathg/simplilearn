<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CategorieDepense extends Model {
    protected $table = 'categories_depenses';
    protected $fillable = ['boutique_id','nom','icone'];
    public function boutique()  { return $this->belongsTo(Boutique::class); }
    public function depenses()  { return $this->hasMany(Depense::class, 'categorie_id'); }
}