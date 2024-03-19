<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reporte;
use Illuminate\Support\Facades\Validator;
class ReportesController extends Controller
{
    public function index(){
        return response()->json(["msg"=>"reportes encontrados",
        "data :"=>Reporte::all()],200);
    }


    
    public function store(Request $request)
    {
      $validate = Validator::make(
        $request->all(),[
            "precio"=>"required|min:1",
            "fecha_entrega"=>"required",
            "ingreso"=>"required|exists:ingresos_reparaciones,id"
        ]
      );

      if ($validate->fails())
      {
        return response()->json(["msg"=>"data failed", "data : "=>$validate->errors()], 422);
      }


      $reporte = new Reporte();
      $reporte->precio=$request->precio;
      $reporte->fecha_entrega=$request->fecha_entrega;
      $reporte->ingreso=$request->ingreso;
      $reporte->save();
      return response()->json(["msg"=>"reporte agregado correctamente"],200);
    }


    public function update(Request $request,int $id)
    {
        $validate = Validator::make(
            $request->all(),[
                "precio"=>"required|min:1",
                "fecha_entrega"=>"required",
                "ingreso"=>"required|exists:ingresos_reparaciones,id"
            ]
          );

      if ($validate->fails())
      {
        return response()->json(["msg"=>"data failed", "data : "=>$validate->errors()], 422);
      }

      $reporte = Reporte::find($id);
      if($reporte)
      {
        $reporte->precio=$request->get('precio',$reporte->precio);
        $reporte->fecha_entrega=$request->get('fecha_entrega',$reporte->fecha_entrega);
        $reporte->ingreso=$request->get('ingreso',$reporte->ingreso);

        $reporte->save();
        return response()->json(["msg"=>"reporte actualizado","data"=>$reporte,],202);
      }
      return response()->json([
        "msg"   =>"reporte not found"
    ],404);


    }

    public function delete(int $id){
        $reporte = Reporte::find($id);

        if($reporte)
        {
          $reporte->delete();
          return response()->json(["reporte eliminado correctamente"],200);
        }
        return response()->json(["No se encontro el reporte"],404);

    }


}
