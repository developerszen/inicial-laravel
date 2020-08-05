<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerified;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'email' => 'email|unique:users,email',
            'password' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'email_verified_token' => $this->generateToken(),
        ]);

        Mail::to($user->email)->send(new EmailVerified($user));

        return $user;
    }

    function verifyEmail(Request $request) {
        $user = User::where('email_verified_token', $request->query('email_verified_token'))->firstOrFail();
    }

    private function generateToken() {
        $token = Str::random(80);

        $token_exists = User::where('email_verified_at', $token)->exists();

        if ($token_exists) {
            $this->generateToken();
        }

        return $token;
    }
}
