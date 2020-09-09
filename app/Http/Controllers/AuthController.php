<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $ttl_remember = 43200;

    protected $ttl_default = 60;

    function login(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        $remember = $request->input('remember');

        $token = auth()->setTTL($this->getTTL($remember))->attempt($credentials);

        if($token) {
            return response([
                'token' => $token,
                'success' => true,
            ]);
        }

        return response([
            'error' => 'Unauthorized',
        ], 401);
    }

    private function getTTL($remember) {
        return $remember ? $this->ttl_remember : $this->ttl_default;
    }

    function logout() {
        auth()->logout();

        return response([], 204);
    }
}
