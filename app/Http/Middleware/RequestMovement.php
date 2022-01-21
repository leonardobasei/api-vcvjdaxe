<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RequestMovement
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->has('sku') || !$request->has('quantity')) {
            return response()->json([
                "message" => "The request must have the sku and quantity parameters"
            ], 403);
        }

        return $next($request);
    }
}
