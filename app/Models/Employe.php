<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Employe extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'poste',
        'contact',
        'genre',
        'photo',
        'adresse',
    ];

    public function commentaires()
{
    return $this->morphMany(Commentaire::class, 'commentable');
}

public function tasks()
{
    return $this->hasMany(Tache::class, 'employe_id'); // 'employe_id' est la clé étrangère dans la table tasks
}

public function projets()
{
    return $this->hasMany(Projet::class, 'employe_id');
}
}


