<?php

namespace App\Filters\Recipe;

use Closure;

class Category
{
    public function handle($recipes, Closure $next)
    {
        $categories = request()->has('categories') ? array_map('intval',explode(",", request('categories'))) : [];

        if (!empty($categories)) {
            $recipes = $recipes->whereIn("category_id" , $categories);
        }

        return $next($recipes);
    }

}
