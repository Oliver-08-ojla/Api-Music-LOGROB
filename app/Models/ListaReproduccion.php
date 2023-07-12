<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class ListaReproduccion extends Model
{
    use HasFactory;

    public $timestamps=false;


    protected $fillable = [
       
        'user_id',
        'nombre',
        'fecha',
    ];

    public function Usuarios(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function Invitaciones(): HasMany
    {
        return $this->hasMany(Invitacion::class,'lista_reproduccion_id');
    }

    public function ListaCanciones(): HasMany
    {
        return $this->hasMany(ListaCancion::class,'lista_reproduccion_id');
    }



}
