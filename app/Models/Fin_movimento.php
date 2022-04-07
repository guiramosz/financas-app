<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fin_movimento extends Model
{
    use HasFactory;
    //campos que podem ser alterados. Vazio, atualiza todos
    protected $guarded = [];
    
    public function user()
    {
    return $this->belongsTo('App\Models\User');
    }
}
