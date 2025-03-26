<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = [
        'nom', 'description', 'date_ouverture', 'prix_moyen',
        'latitude', 'longitude', 'contact_nom', 'contact_email', 'photo'
    ];

}
