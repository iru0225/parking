<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Role;

class RoleController extends Controller
{
    public function getRoles() {
        return Role::All();
    }

    public function getRole(String $id) {
        return Role::find($id);
    }

    public function createRole(Request $request) {        
        if (!isset($request->role)) {
            abort(response([
                'message' => 'Role is required',
                'code' => 400
            ], 400));
        }

        $data = $request;
        $id = Str::uuid();
        
        try {
            Role::create([
                'id' => $id,
                'role' => $data->role
            ]);
            return response([
                'message' => 'Success'
            ]);
        } catch (\Throwable $th) {
            abort(response([
                'message' => 'Something went wrong',
                'code' => 502
            ], 502));
        }        
    }
}
