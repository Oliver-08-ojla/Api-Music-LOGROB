<?php

namespace App\Http\Controllers;

use App\Models\Invitacion;
use App\Models\ListaReproduccion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\MockObject\Invocation;

class InvitacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     private  $rules = array(
        'usuario_invitado_id' => 'required',
        'lista_reproduccion_id' => 'required',
      
    );
    private $messages = array(
        'usuario_invitado_id.required' => 'Es requerido el usuario invitado.',
        'lista_reproduccion_id.required' => 'Es requerido la lista de reproduccion.',
    );




    public function index()
    {
        $usuario = Auth::guard('sanctum')->user();
        $invitacionesRecibidas=Invitacion::with('UsuarioInvitado','UsuarioInvitador','ListaDeReproduccion')->where('usuario_invitado_id','=',$usuario->id)->where('estado','=',0)->get();
        return response()->json([
            'invitacionesRecibidas'=>$invitacionesRecibidas
        ]);
    }

    public function enviadas()
    {
        $usuario = Auth::guard('sanctum')->user();

        $invitacionesEnviadas=Invitacion::with('UsuarioInvitado','UsuarioInvitador','ListaDeReproduccion')->where('usuario_invitador_id','=',$usuario->id)->get();
        
        return response()->json([
            'invitacionesEnviadas'=>$invitacionesEnviadas
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

        $isMyPerson=$request->usuario_invitado_id==$usuario->id;
        if ($isMyPerson) {
            return response()->json([
                "message" => "No puedes enviarte invitacion a ti mismo"
            ], 500);
        }

        $isMyList=ListaReproduccion::where('id', '=', $request->lista_reproduccion_id)->where('user_id','=',$usuario->id)->first();
        if (!$isMyList) {
            return response()->json([
                "message" => "No puedes agregar a alguien si la lista de reproduccion no te pertenece"
            ], 500);
        }




        $nombrePersonaEnviada=Invitacion::where('usuario_invitado_id', '=', $request->usuario_invitado_id)->where('usuario_invitador_id', '=', $usuario->id)->where('estado','=',0)->first();
        if ($nombrePersonaEnviada) {
            return response()->json([
                "message" => "Ya se ha enviado una invitacion"
            ], 500);
        }





        Invitacion::create([
            'usuario_invitado_id'=>$request->usuario_invitado_id,
            'usuario_invitador_id'=>$usuario->id,
            'lista_reproduccion_id'=>$request->lista_reproduccion_id,
        ]);

        return response()->json([
           
            "message" => "Se envio la invitacion",
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Invitacion $invitacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
       Invitacion::find($id)->update([
        'estado'=>1
       ]);
       return response()->json([
           
        "message" => "Invitacion aceptada",
    ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $usuario = Auth::guard('sanctum')->user();

        $invitacionesExistentes=Invitacion::findOrFail($id)->first();

        if($invitacionesExistentes){
            $invitacionesExistentes->delete();

            return response()->json([
           
                "message" => "Se elimino correctamente",
            ]); 
        }else 
        return response()->json([
           
            "message" => "No se puede eliminar una lista que no es de usted",
        ],500); 
    }
}
