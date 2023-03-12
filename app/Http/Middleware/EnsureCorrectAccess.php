<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureCorrectAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $type)
    {
        $case = $request->route($type);

        if (!$case) {
            return $next($request);
        }

        if ($case->user_id && $case->user_id !== auth()->user()->id) {
            return redirect()->route('home')->with('error', 'You do not have access to this page.');
        }

        return $next($request);
    }
}
