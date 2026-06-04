<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampagneIA extends Model {
    protected $table = 'campagnes_ia';
    protected $fillable = [
        'boutique_id','admin_id','titre','description',
        'reseau','type_contenu','prompt_utilisateur',
        'contenu_genere','image_url','statut',
        'publie_at','programme_at','metriques',
    ];
    protected $casts = [
        'publie_at'    => 'datetime',
        'programme_at' => 'datetime',
        'metriques'    => 'array',
    ];
    public function boutique() { return $this->belongsTo(Boutique::class); }
    public function admin()    { return $this->belongsTo(Admin::class); }
    public function getReseauLabelAttribute(): string {
        return match($this->reseau) {
            'instagram' => 'Instagram',
            'facebook'  => 'Facebook',
            'tiktok'    => 'TikTok',
            'tous'      => 'Tous les reseaux',
            default     => $this->reseau,
        };
    }
    public function getStatutBadgeAttribute(): string {
        return match($this->statut) {
            'publie'    => 'badge-success',
            'programme' => 'badge-info',
            'echoue'    => 'badge-danger',
            default     => 'badge-gray',
        };
    }
}