<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reparacion;
use Illuminate\Support\Facades\Validator;

class ReparacionesController extends Controller
{
    public function index()
    {
        return response()->json(Reparacion::all(), 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make(
            $request->all(), [
                "tipo_reparaciones" => "required"
            ]
        );

        if ($validate->fails()) {
            return response()->json(["msg" => "data failed", "data : " => $validate->errors()], 422);
        }

        $reparacion = Reparacion::create($request->all());

        return response()->json(["msg" => "Reparacion agregada correctamente"], 200);
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make(
            $request->all(), [
                "tipo_reparaciones" => "required"
            ]
        );

        if ($validate->fails()) {
            return response()->json(["msg" => "data failed", "data : " => $validate->errors()], 422);
        }

        $reparacion = Reparacion::find($id);
        if (!$reparacion) {
            return response()->json(["msg" => "Reparacion no encontrada"], 404);
        }

        $reparacion->update($request->all());

        return response()->json(["msg" => "Reparacion actualizada correctamente"], 200);
    }

    public function destroy($id)
    {
        $reparacion = Reparacion::find($id);
        if (!$reparacion) {
            return response()->json(["msg" => "Reparacion no encontrada"], 404);
        }

        $reparacion->delete();

        return response()->json(["msg" => "Reparacion eliminada correctamente"], 200);
    }
}
