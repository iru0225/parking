<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function createUser(Request $request) {
        if (!isset($request->username)) {
            abort(response([
                'message' => 'username is required',
                'code' => 400
            ], 400));
        }
        if (!isset($request->password)) {
            abort(response([
                'message' => 'password is required',
                'code' => 400
            ], 400));
        }
        if (!isset($request->name)) {
            abort(response([
                'message' => 'name is required',
                'code' => 400
            ], 400));
        }
        if (!isset($request->role_id)) {
            abort(response([
                'message' => 'role_id is required',
                'code' => 400
            ], 400));
        }
        $data = $request;
        $id = Str::uuid();
        $newPassword = password_hash($data->password, PASSWORD_BCRYPT);
        
        try {
            User::create([
                'id' => $id,
                'name' => $data->name,
                'username' => $data->username,
                'password' => $newPassword,
                'role_id' => $data->role_id
            ]);

            return response([
                'message' => 'User added'
            ]);
        } catch (\Throwable $th) {
            abort(response([
                'message' => 'Something went wrong',
                'code' => 502
            ], 502));
        }
    }

    public function login(Request $request) {
        $user = User::where('username', '=', $request->username)->first();
        $ability = [];
        if (password_verify($request->password, $user->password)) {
            $role =  Role::find($user->role_id);
            if ($role->role === 'Admin') {
                $ability = ['get-report','get-user','create-parking'];
            } else {
                $ability = ['get-user','create-parking'];
            }
            $token = $user->createToken('personal-token', $ability, expiresAt:now()->addDay())->plainTextToken;
            return response([
                'token' => $token
            ], 200);
        }
    }
}
