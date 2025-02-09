<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'status',
        'projet_id',
        'employe_id',
    ];

    public function project()
    {
        return $this->belongsTo(Projet::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employe::class, 'employe_id');
    }
}
