<?php

namespace App\Http\Controllers;

use App\Models\Cancion;
use App\Models\ListaCancion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ListaCancionController extends Controller
{
    private  $rules = array(
        'titulo' => 'required',
        'duracion' => 'required',
        'rank' => 'required',
        'url' => 'required',

        'lista_reproduccion_id'=> 'required',
        'fecha'=> 'required',



      
    );
    private $messages = array(
        'titulo.required' => 'Titulo es requerido.',
        'duracion.required' => 'Duracion es requerido.',
        'rank.required' => 'Rank es requerido.',
        'url.required' => 'Url es requerido.',

        'lista_reproduccion_id.required' => 'Nombre de lista de repdroduccion es requerido.',
        'fecha.required' => 'Fecha es requerido.',


       
    );



    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $usuario = Auth::guard('sanctum')->user();

        $validator = Validator::make($request->all(), $this->rules, $this->messages);
        if ($validator->fails()) {
            $messages = $validator->messages();
            return response()->json(["message" => $messages], 500);
        }

        $CancionCreada=Cancion::create([
            'titulo'=>$request->titulo,
            'duracion'=>$request->duracion,
            'rank'=>$request->rank,
            'url'=>$request->url
        ]);

        $CancionesAgregadas=ListaCancion::create([
            'lista_reproduccion_id'=>$request->lista_reproduccion_id,
            'cancion_id'=>$CancionCreada->id,
            'user_id'=>$usuario->id,
            'fecha'=>$request->fecha,
        ]);


        return response()->json([
            'message'=>'Cancion agregada a la lista de reproduccion.'
        ]);
    }

        



    

    /**
     * Display the specified resource.
     */
    public function show(ListaCancion $listaCancion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ListaCancion $listaCancion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lista=ListaCancion::find($id);

       Cancion::find($lista->cancion_id)->delete();
       $lista->delete();
       
       return response()->json([
        'message'=>'Cancion eliminada de la lista de reproduccion.'
    ]);
    }
}
