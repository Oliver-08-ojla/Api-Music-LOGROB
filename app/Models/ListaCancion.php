<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



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

    public function ListaDeReproduccion(): BelongsTo
    {
        return $this->belongsTo(ListaReproduccion::class,'lista_reproduccion_id');
    }

    public function Canciones(): BelongsTo
    {
        return $this->belongsTo(Cancion::class,'cancion_id');
    }


    public function Usuarios(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
