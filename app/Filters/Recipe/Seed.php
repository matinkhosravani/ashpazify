<?php

namespace App\Filters\Recipe;

use App\Models\Recipe;
use Closure;
use Illuminate\Support\Facades\Redis;

class Seed
{
    public function handle($recipes, Closure $next)
    {
        if (!request()->has("seed")){
            return $next($recipes);
        }

        $seed = request('seed');

        $redisKey = "shuffled_recipes:$seed";

        // Check if the recipes have been shuffled for this seed
        if (Redis::exists($redisKey)) {
            $shuffledRecipeIds = Redis::smembers($redisKey);
            $recipes->whereNotIn('id', array_map('intval',$shuffledRecipeIds));
        }

        return $next($recipes);
    }

}
