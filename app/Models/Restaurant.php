<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nom',
        'description',
        'date_ouverture',
        'prix_moyen',
        'latitude',
        'longitude',
        'contact_nom',
        'contact_email',
        'photo',
        // autres champs si besoin
    ];

    /**
     * L’utilisateur qui a créé le restaurant
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Les avis liés à ce restaurant
     */
    public function avis()
    {
        return $this->hasMany(Avis::class, 'restaurant_id');
    }
}
