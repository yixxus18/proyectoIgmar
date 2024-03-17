<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dispositivo;
use Illuminate\Support\Facades\Validator;


class DispositivosController extends Controller
{
    public function index()
    {
        return response()->json(Dispositivo::all(), 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make(
            $request->all(), [
                "marca" => "required",
                "modelo" => "required",
                "tipo_dispositivos" => "required"
            ]
        );

        if ($validate->fails()) {
            return response()->json(["msg" => "data failed", "data : " => $validate->errors()], 422);
        }

        $dispositivo = Dispositivo::create($request->all());

        return response()->json(["msg" => "Dispositivo agregado correctamente"], 200);
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make(
            $request->all(), [
                "marca" => "required",
                "modelo" => "required",
                "tipo_dispositivos" => "required"
            ]
        );

        if ($validate->fails()) {
            return response()->json(["msg" => "data failed", "data : " => $validate->errors()], 422);
        }

        $dispositivo = Dispositivo::find($id);
        if (!$dispositivo) {
            return response()->json(["msg" => "Dispositivo no encontrado"], 404);
        }

        $dispositivo->update($request->all());

        return response()->json(["msg" => "Dispositivo actualizado correctamente"], 200);
    }

    public function destroy($id)
    {
        $dispositivo = Dispositivo::find($id);
        if (!$dispositivo) {
            return response()->json(["msg" => "Dispositivo no encontrado"], 404);
        }

        $dispositivo->delete();

        return response()->json(["msg" => "Dispositivo eliminado correctamente"], 200);
    }
}
