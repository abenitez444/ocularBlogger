<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function tablePermissions(Request $request)
    {
        if ($request->perPage > 0)
        {
            $data = Permission::orderBy('created_at', 'desc')->paginate($request->perPage);
        }
        else
        {
            $data = Permission::orderBy('created_at', 'desc')->get();
        }
        return response()->json($data);
    }
    public function savePermissions(Request $request)
    {
        $permission = Permission::firstOrNew([
            'id' => $request->id
        ]);
        
        $permission->fill($request->all());
        $permission->save();

        return response()->json($permission);
    }
    public function deletePermissions($id)
    {
        $permission = Permission::find($id);
        $permission->delete();

        return response()->json($permission);
    }
}
