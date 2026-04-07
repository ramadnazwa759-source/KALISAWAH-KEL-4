<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; // untuk logging sistem terdistribusi

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $user = User::where('email',$request->email)->first();

        if(!$user || !Hash::check($request->password,$user->password)){
            return response()->json([
                "message"=>"Email atau password salah"
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

    public function register(Request $request)
{
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role
    ]);

    return response()->json([
        'message' => 'User berhasil dibuat',
        'user' => $user
    ]);

}
    public function showRegister()
{
    return view('admin.auth.register'); // untuk menampilkan form register (frontnazwa)
}
}

