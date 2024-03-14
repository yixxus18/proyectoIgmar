<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Categoria;

use Illuminate\Support\Facades\Validator;

class CategoriasController extends Controller
{
    public function index()
    {
        return response()->json(["msg"=>"categorias encontradas",
        "data :"=>Categoria::all()],200);
    }


    public function store(Request $request)
    {
      $validate = Validator::make(
        $request->all(),[
            "tipo_categoria"=>"required"
        ]
      );

      if ($validate->fails())
      {
        return response()->json(["msg"=>"data failed", "data : "=>$validate->errors()], 422);
      }


      $categoria = new Categoria();
      $categoria->tipo_categoria=$request->tipo_categoria;
      $categoria->save();
      return response()->json(["msg"=>"Categoria agregada correctamente"],200);
    }


    public function update(Request $request,int $id)
    {
      $validate = Validator::make(
        $request->all(),[
            "tipo_categoria"=>"required"
        ]
      );

      if ($validate->fails())
      {
        return response()->json(["msg"=>"data failed", "data : "=>$validate->errors()], 422);
      }

      $categoria = Categoria::find($id);
      if($categoria)
      {
        $categoria->tipo_categoria=$request->get('tipo_categoria',$categoria->tipo_categoria);
        $categoria->save();
        return response()->json(["msg"=>"categoria actualizada","data"=>$categoria,],202);
      }
      return response()->json([
        "msg"   =>"categoria not found"
    ],404);


    }



    public function delete(int $id)
    {
        $categoria = Categoria::find($id);

        if($categoria)
        {
          $categoria->delete();
          return response()->json(["Categoria eliminada correctamente"],202);
        }
        return response()->json(["No se encontro la categoria"],404);
    }
    
   


}
