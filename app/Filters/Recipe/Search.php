<?php

namespace App\Filters\Recipe;

use Closure;

class Search
{
    public function handle($recipes, Closure $next)
    {
        $search = request('s');
        if (!empty($search)) {
            $recipes = $recipes->where('title', 'LIKE', "%$search%");
        }
        return $next($recipes);
    }

}
