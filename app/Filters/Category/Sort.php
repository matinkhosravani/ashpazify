<?php

namespace App\Filters\Category;

use Closure;

class Sort
{
    public function handle($categories, Closure $next)
    {
        $categories = $categories->orderBy('name' , 'ASC');
        return $next($categories);
    }

}
