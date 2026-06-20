<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnggotaAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('anggota')->check()) {
            return redirect()->route('anggota.login');
        }
        return $next($request);
    }
}
