<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 'description', 'date_debut', 'date_fin', 'statut', 'type_projet', 'employe_id',
    ];

    public function superviseur()
    {
        return $this->belongsTo(Employe::class, 'employe_id');
    }

    public function taches()
    {
        return $this->hasMany(Tache::class);
    }
}
