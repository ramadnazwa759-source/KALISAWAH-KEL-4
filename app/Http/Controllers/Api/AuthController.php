<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function login(Request $request)
{
    $user = User::where('email',$request->email)->first();

    if(!$user){
        return response()->json([
            "message"=>"User tidak ditemukan"
        ],404);
    }

    if(!Hash::check($request->password,$user->password)){
        return response()->json([
            "message"=>"Password salah"
        ],401);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        "message"=>"Login berhasil",
        "user"=>$user,
        "token"=>$token
    ]);
}

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            "message"=>"Logout berhasil"
        ]);
    }

//     public function register(Request $request)
// {
//     $user = User::create([
//         'name' => $request->name,
//         'email' => $request->email,
//         'password' => Hash::make($request->password),
//         'role' => $request->role
//     ]);

//     return redirect('/admin/login')->with('success', 'Registrasi berhasil, silakan login');
// }

    public function showRegister()
    {
        return view('auth.register');
    }

}
