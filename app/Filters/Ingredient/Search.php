<?php

namespace App\Filters\Ingredient;

use Closure;

class Search
{
    public function handle($ingredients, Closure $next)
    {
        $search = request('s');
        if (!empty($search)) {
            $ingredients = $ingredients->where('title', 'LIKE', "%$search%");
        }
        return $next($ingredients);
    }

}
