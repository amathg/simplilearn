<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class JournalAction extends Model {
    protected $table = 'journal_actions';
    protected $fillable = ['boutique_id','admin_id','action','module','description','ip_address','donnees_avant','donnees_apres'];
    protected $casts = ['donnees_avant' => 'array', 'donnees_apres' => 'array'];
    public function boutique() { return $this->belongsTo(Boutique::class); }
    public function admin()    { return $this->belongsTo(Admin::class); }
}