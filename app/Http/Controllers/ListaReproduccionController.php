<?php

namespace App\Http\Controllers;

use App\Models\Cancion;
use App\Models\Invitacion;
use App\Models\ListaReproduccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\Foreach_;

class ListaReproduccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     private  $rules = array(
        'nombre' => 'required',
        'fecha' => 'required',
      
    );
    private $messages = array(
        'nombre.required' => 'Nickname es requerido.',
        'fecha.required' => 'Debe ingresar una fecha.',
    );


    public function index()
    {
        $usuario = Auth::guard('sanctum')->user();

        $listaReproduccion=ListaReproduccion::where('user_id', '=', $usuario->id)->get();

        return response()->json([
            "ListaReproduccion" => $listaReproduccion,
        ]);
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

        $nombreListaExistente=ListaReproduccion::where('nombre', '=', $request->nombre)->where('user_id', '=', $usuario->id)->first();
        if ($nombreListaExistente) {
            return response()->json([
                "message" => "Ya existe una lista con este nombre"
            ], 500);
        }


        ListaReproduccion::create([
            'nombre'=>$request->nombre,
            'fecha'=>$request->fecha,
            'user_id'=>$usuario->id

        ]);

        return response()->json([
           
            "message" => "Se creo la lista exitosamente",
        ]);
    
    
    }

    public function ListasAceptadas()
    {
        $usuario = Auth::guard('sanctum')->user();

        $listaReproduccion=Invitacion::with('ListaDeReproduccion','UsuarioInvitado','UsuarioInvitador')->where('usuario_invitado_id', '=', $usuario->id)->where('estado','=', 1)->get();

        return response()->json([
            "ListaReproduccion" => $listaReproduccion,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $usuario = Auth::guard('sanctum')->user();

        $listaReproduccion=ListaReproduccion::with('Usuarios','ListaCanciones','ListaCanciones.Canciones', 'ListaCanciones.Usuarios')->where('user_id', '=', $usuario->id)->get();

        return response()->json([

            "ListaReproduccion"=>$listaReproduccion

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ListaReproduccion $listaReproduccion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $usuario = Auth::guard('sanctum')->user();
       
        $listaReproduccion=ListaReproduccion::findOrFail($id)->where('user_id', '=', $usuario->id)->first();

        if($listaReproduccion){
            $canciones=$listaReproduccion->ListaCanciones;

            foreach ($canciones as $cancion) {
                Cancion::find($cancion->cancion_id)->delete();
            }
          
            $listaReproduccion->delete();

            return response()->json([
           
                "message" => "Se elimino correctamente",
            ]); 
        }else 
        return response()->json([
           
            "message" => "No se puede eliminar una lista que no es de usted",
        ],500); 

        

        
    }
}
