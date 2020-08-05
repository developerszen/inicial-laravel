<?php

namespace App\Http\Middleware;

use Closure;

class EmailVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if ($user->email_verified_at) {
            return $next($request);
        }

        return response()->json([
            'error' => 'Email no verified',
        ]);
    }
}
