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

    public function register(Request $request)
{
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role
    ]);

    return redirect('/login')->with('success', 'Registrasi berhasil, silakan login');
}

    public function showRegister()
    {
        return view('auth.register');
    }

    // metrics sistem terdistribusi
    public function metrics()
{
    $status = 1;
    $memory = memory_get_usage();
    $time = time();

    $metrics = "
# HELP app_status Status aplikasi (1=running)
# TYPE app_status gauge
app_status $status

# HELP memory_usage Memory usage dalam bytes
# TYPE memory_usage gauge
memory_usage $memory

# HELP request_time Timestamp request
# TYPE request_time gauge
request_time $time
";

    return response($metrics, 200)
        ->header('Content-Type', 'text/plain');
}
}