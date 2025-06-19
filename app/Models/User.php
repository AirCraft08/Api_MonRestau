<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        // autres champs si besoin
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les avis laissés par cet utilisateur
     */
    public function avis()
    {
        return $this->hasMany(Avis::class, 'user_id');
    }

    /**
     * Les restaurants créés par cet utilisateur
     */
    public function restaurants()
    {
        return $this->hasMany(Restaurant::class, 'user_id');
    }
}
