<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accesorio;
use Illuminate\Support\Facades\Validator;

class AccesoriosController extends Controller
{
    public function store(Request $request)
    {
      $validate = Validator::make(
        $request->all(),[
            "nombre"=>"required",
            "descripcion"=>"required",
            "precio"=>"required",
            "cantidad"=>"required",
            "tipo_categoria"=>"required"
        ]
      );

      if ($validate->fails())
      {
        return response()->json(["msg"=>"data failed", "data : "=>$validate->errors()], 422);
      }


      $accesorio = new Accesorio();
      $accesorio->nombre=$request->nombre;
      $accesorio->descripcion=$request->descripcion;
      $accesorio->precio=$request->precio;
      $accesorio->cantidad=$request->cantidad;
      $accesorio->tipo_categoria=$request->tipo_categoria;
      $accesorio->save();
      return response()->json(["msg"=>"Accesorio agregado correctamente"],200);
    }

    public function index()
    {
        $accesorios = Accesorio::all();
        return response()->json(["msg"=>"Accesorios encontrados", "data"=>$accesorios], 200);
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make(
            $request->all(),[
                "nombre"=>"required",
                "descripcion"=>"required",
                "precio"=>"required",
                "cantidad"=>"required",
                "tipo_categoria"=>"required"
            ]
        );

        if ($validate->fails())
        {
            return response()->json(["msg"=>"data failed", "data"=>$validate->errors()], 422);
        }

        $accesorio = Accesorio::find($id);
        if (!$accesorio) {
            return response()->json(["msg"=>"Accesorio no encontrado"], 404);
        }

        $accesorio->nombre=$request->nombre;
        $accesorio->descripcion=$request->descripcion;
        $accesorio->precio=$request->precio;
        $accesorio->cantidad=$request->cantidad;
        $accesorio->tipo_categoria=$request->tipo_categoria;
        $accesorio->save();

        return response()->json(["msg"=>"Accesorio actualizado correctamente"],200);
    }

    public function delete($id)
    {
        $accesorio = Accesorio::find($id);
        if (!$accesorio) {
            return response()->json(["msg"=>"Accesorio no encontrado"], 404);
        }

        $accesorio->delete();
        return response()->json(["msg"=>"Accesorio eliminado correctamente"],200);
    }

}
