<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RequestProduct
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->has('name') || !$request->has('quantity')) {
            return response()->json([
                "message" => "The request must have the name and quantity parameters"
            ], 400);
        }

        return $next($request);
    }
}
