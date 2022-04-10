<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function updateUser(User $u){
        $u=User::where('id',request()->id)->first();
        $user= request()->validate([
            'password'=>request()->password!=null?'min:8 | sometimes | required': '',
            'confirm_password'=>'same:password',
            'email'=>'required',
            'firstName'=>'required',
            'lastName'=>'required',
            'username'=>'required',
            'role_id'=>'required',
        ]);
        // dd(request()->all);
        $u->update(request()->has('password') ?request()->all() : request()->except(['password']));
        $u->fresh();

        return response()->json($user,201);

    }

    public function getUsers(){
        return User::with('role')->get();
    }

    public function getRoles(){
        return Role::with('permissions')->get();
    }

    public function createUser(){
        $request=request();
        $validator=$request->validate([
            'firstName'=>'required',
            'lastName'=>'required',
            'username'=>'required |unique:users',
            'email'=>'required|email',
            'role_id'=>'required',
            'password'=>'required| min:8',
            'confirm_password'=>'same:password',
        ]);
        info($validator);

        $user=User::create([
            'firstName'=>request('firstName'),
            'lastName'=>request('lastName'),
            'username'=>request('username'),
            'email'=>request('email'),
            'password'=>request('password'),
            'role_id'=>request('role_id'),

        ]);
    }

    public function deleteUser(){
        return User::where('id',request()->id)->delete();
    }

    public function getPermissions(){
        return Permission::all();
    }

    public function updateRole(){
        $request=request();
        $validator=$request->validate([
            'name'=>'required',
        ]);
        $role=Role::where('id',request()->id)->first();
        $role->name=(request()->name);
        $role->save();
        $role->permissions()->sync(request()->permission_ids);
        return response()->json($role, 201);
    }

    public function createRole(){
        $request=request();
        $validator=$request->validate([
            'name'=>'required',
        ]);
        $role=Role::create([
            'name'=>request()->name
        ]);
        $role->permissions()->sync(request()->permission_ids);
        return response()->json($role, 201);

    }

    public function deleteRole(){
        $role= Role::find(request()->id);
        $role->permissions()->detach();
        $role->delete();
        return response()->json([], 204);

    }
}
