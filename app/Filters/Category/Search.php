<?php

namespace App\Filters\Category;

use Closure;

class Search
{
    public function handle($categories, Closure $next)
    {
        $search = request('s');
        if (!empty($search)) {
            $categories = $categories->where('name', 'LIKE', "%$search%");
        }
        return $next($categories);
    }

}
