<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TeacherMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->role === 'teacher') {
            return $next($request);
        }

        return response()->json([
            'message' => 'Only teachers can access this endpoint',
        ], 403);
    }
}
