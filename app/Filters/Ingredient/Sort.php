<?php

namespace App\Filters\Ingredient;

use Closure;

class Sort
{
    public function handle($ingredients, Closure $next)
    {
        $ingredients = $ingredients->orderBy('title' , 'ASC');
        return $next($ingredients);
    }

}
