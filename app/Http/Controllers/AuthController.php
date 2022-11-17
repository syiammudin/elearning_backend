<?php

namespace App\Http\Controllers;

use Adldap\Adldap;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Adldap\Laravel\AdldapServiceProvider;
use Adldap\Laravel\AdldapAuthServiceProvider;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credential = [
            'email' => strtolower($request->email),
            'password' => $request->password
        ];

        return $this->loginLocally($credential, $request);
    }

    public function loginLocally($credential, $request)
    {
        $user = User::where('email', strtolower($credential['email']))->first();

        if (!$user) {
            return response(['message' => 'Email tidak terdaftar'], 401);
        }
        if (!password_verify($credential['password'], $user->password)) {
            return response(['message' => 'Password salah'], 401);
        }
        Auth::login($user, true);

        return response()->json([
            'token' => $user->createToken($request->device_name ?: 'web')->plainTextToken,
            'user' => $user
        ]);
    }


    public function logout(Request $request)
    {

        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach ($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                if (isset($_COOKIE[$name])) {
                    unset($_COOKIE[$name]);
                    Cookie::queue(Cookie::forget($name));
                    setcookie($name, null, time() - 3600, '/', env('FRONTEND'));
                }
            }
        }
        $request->user()->currentAccessToken()->delete();
        $request->user()->tokens()->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        auth()->logout();
        return response('', 204);
    }

    public function me()
    {
        return User::find(auth()->id());
    }
}
