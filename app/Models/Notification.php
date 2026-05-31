<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model {
    protected $fillable = [
        'boutique_id','titre','message','type','lien','lue'
    ];

    protected $casts = ['lue' => 'boolean'];

    public function boutique() { return $this->belongsTo(Boutique::class); }
}