<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function findByUsername(){
        $username=request()->username;
        // dd($username);
        return User::where('username',$username)->first();
    }
}
