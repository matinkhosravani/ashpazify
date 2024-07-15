<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class StoreShuffledRecipes
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        if ($request->has('seed')) {
            $recipes = $request->recipes;
            if ($recipes == null){
                return $response;
            }

            $seed = $request->get("seed");
            $key = "shuffled_recipes:$seed";
            Redis::expire($key, 6 * 60 * 60);
            foreach ($recipes->pluck('id')->toArray() as $id) {
                Redis::sadd($key, $id);
            }
        }

        return $response;
    }
}
