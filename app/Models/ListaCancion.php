<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaCancion extends Model
{
    use HasFactory;

    public $timestamps=false;


    protected $fillable = [
       
        'lista_reproduccion_id',
        'cancion_id',
        'user_id',
        'fecha',
    ];
}
