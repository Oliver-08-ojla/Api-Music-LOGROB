<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitacion extends Model
{
    use HasFactory;

    
    public $timestamps=false;


    protected $fillable = [
       
        'estado',
        'usuario_invitado_Id',
        'usuario_invitador_id',
        'lista_reproduccion_id',
    ];
}
