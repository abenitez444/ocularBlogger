<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rol;

class RolController extends Controller
{
    public function allRoles(Request $request)
    {
        if ($request->perPage > 0)
        {
            $data = Rol::orderBy('created_at', 'desc')->paginate($request->perPage);
        }
        else
        {
            $data = Rol::orderBy('created_at', 'desc')->get();
        }
        return response()->json($data);
    }
    public function saveRoles(Request $request)
    {
        $rol = Rol::firstOrNew([
            'id' => $request->id
        ]);
        
        $rol->fill($request->all());
        $rol->save();

        return response()->json($rol);
    }
    public function deleteRoles($id)
    {
        $rol = Rol::find($id);
        $rol->delete();

        return response()->json($rol);
    }
}
