<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'contenu',
        'projet_id',
        'commentable_id',
        'commentable_type',
    ];



    public function projet()
{
    return $this->belongsTo(Projet::class);
}


public function commentable()
{
    return $this->morphTo();
}


}
