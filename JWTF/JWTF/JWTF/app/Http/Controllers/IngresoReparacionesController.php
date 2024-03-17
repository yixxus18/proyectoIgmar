<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingreso_Reparacion;
use Illuminate\Support\Facades\Validator;

class IngresoReparacionesController extends Controller
{
    
    public function store(Request $request)
    {
      $validate = Validator::make(
        $request->all(),[
            "user"=>"required|exists:users,id",
            "dipositivo"=>"required|exists:dispositivos,id",
            "reparacion"=>"required|exists:reparaciones,id",
            "descripcion"=>"required|min:1",
            "fecha_ingreso"=>"required",
            "estatus"=>"required|min:1|max:9",

            
        ]
      );

      if ($validate->fails())
      {
        return response()->json(["msg"=>"data failed", "data : "=>$validate->errors()], 422);
      }


      $ingreso = new Ingreso_Reparacion();
      $ingreso->user=$request->user;
      $ingreso->dispositivo=$request->dispositivo;
      $ingreso->reparacion=$request->reparacion;
      $ingreso->descripcion=$request->descripcion;
      $ingreso->fecha_ingreso=$request->fecha_ingreso;
      $ingreso->estatus=$request->estatus;
      
      
      $ingreso->save();
      return response()->json(["msg"=>"ingreso_reparacion agregado correctamente"],200);
    }

    public function index(){
      return response()->json(["Msg" => "ingreso a reparaciones encontradas","data :"=>Ingreso_Reparacion::all()],200);
    }

    public function delete(int $id)
    {
        $ingreso= Ingreso_Reparacion::find($id);

        if($ingreso)
        {
            $ingreso->delete();
          return response()->json(['ingreso a reparacion eliminada'],200);
        }
  
        return response()->json(['ingreso a reparacion no encontrada'],404);
    }

    public function update(Request $request, int $id)
    {
        $validate = Validator::make(
            $request->all(),[
                "user"=>"required|exists:users,id",
                "dipositivo"=>"required|exists:dispositivos,id",
                "reparacion"=>"required|exists:reparaciones,id",
                "descripcion"=>"required|min:1",
                "fecha_ingreso"=>"required",
                "estatus"=>"required|min:1|max:9",
    
                
            ]
          );
      if($validate->fails())
      {
          return response()->json(["msg"=>"data failed", "data : "=>$validate->errors()],422);
      }

      $ingreso =Ingreso_Reparacion::find($id);
      if ( $ingreso)
      {
        $ingreso->user=$request->get('user', $ingreso->user);
        $ingreso->dispositivo=$request->get('dispositivo', $ingreso->dispositivo);
        $ingreso->reparacion=$request->get('reparacion', $ingreso->reparacion);
        $ingreso->descripcion=$request->get('descripcion', $ingreso->descripcion);
        $ingreso->fecha_ingreso=$request->get('fecha_ingreso', $ingreso->fecha_ingreso);
        $ingreso->estatus=$request->get('estatus', $ingreso->estatus);
       

        $ingreso->save();
          return response()->json(["msg"=>"ingreso a reparar actualizado","data"=> $ingreso],202);
      }
      return response()->json([
          "msg"   =>"ingreso not found"
      ],404);
    }
}
