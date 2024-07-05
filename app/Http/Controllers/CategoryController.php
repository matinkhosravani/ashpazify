<?php

namespace App\Http\Controllers;

use App\Filters\Category\Search;
use App\Filters\Category\Sort;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Pipeline $pipeline)
    {
        $categories = $pipeline->send(Category::query())
            ->through([
                Search::class,
                Sort::class,
            ])
            ->thenReturn();
        return $categories->paginate($request->perPage ?? 10);
    }

    public function all(Pipeline $pipeline)
    {
        $categories = $pipeline->send(Category::query())
            ->through([
                Search::class,
                Sort::class,
            ])
            ->thenReturn();
        return $categories->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
