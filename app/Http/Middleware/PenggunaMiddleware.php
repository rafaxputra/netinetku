<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Pelanggan;

class PenggunaMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (auth()->check()) {
            $user = auth()->user();
            if (in_array($user->role, $roles)) {
                if ($user->role === 'pelanggan') {
                    $pelanggan = Pelanggan::where('user_id', $user->id)->first();
                    if ($pelanggan && $pelanggan->status === 'nonaktif') {
                        return redirect()->route('inactive.notification');
                    }
                }
                return $next($request);
            }
        }
        
        return redirect('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
