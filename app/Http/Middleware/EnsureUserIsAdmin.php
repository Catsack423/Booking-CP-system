<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = auth()->user();
        if (! $user || ! $user->admin) {
            return redirect('/')->with('error', 'ไม่มีสิทธิ์เข้าใช้งาน');
        }
        return $next($request);
    }
}
