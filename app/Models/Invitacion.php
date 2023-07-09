<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Invitacion extends Model
{
    use HasFactory;

    
    public $timestamps=false;


    protected $fillable = [
       
        'estado',
        'usuario_invitado_id',
        'usuario_invitador_id',
        'lista_reproduccion_id',
    ];

   

    public function ListaDeReproduccion(): BelongsTo
    {
        return $this->belongsTo(ListaReproduccion::class,'lista_reproduccion_id');
    }

    public function UsuarioInvitado(): BelongsTo
    {
        return $this->belongsTo(User::class,'usuario_invitado_id');
    }

    public function UsuarioInvitador(): BelongsTo
    {
        return $this->belongsTo(User::class,'usuario_invitador_id');
    }
}
