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
            "categoria"=>"required"
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
      $accesorio->categoria=$request->categoria;
      $accesorio->save();
      return response()->json(["msg"=>"Accesorio agregado correctamente"],200);
    }
}
