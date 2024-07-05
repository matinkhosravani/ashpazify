<?php

namespace App\Filters\Recipe;

use Closure;

class Ingredient
{
    public function handle($recipes, Closure $next)
    {
        $included_ingredients = request('ingredients');
        $excluded_ingredients = request('excluded_ingredients');

        if (!empty($included_ingredients)) {
            $recipes = $recipes->whereHas('ingredients', function ($q) use ($included_ingredients) {
                $q->whereIn('ingredients.id', $included_ingredients);
            });
        }
        if (!empty($excluded_ingredients)) {
            $recipes = $recipes->whereDoesntHave('ingredients', function ($q) use ($excluded_ingredients) {
                $q->whereIn('ingredients.id', $excluded_ingredients);
            });
        }

        return $next($recipes);
    }

}
