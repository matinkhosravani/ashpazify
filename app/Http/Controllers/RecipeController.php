<?php

namespace App\Http\Controllers;

use App\Filters\Recipe\Category;
use App\Filters\Recipe\Ingredient;
use App\Filters\Recipe\Search;
use App\Http\Resources\RecipeCollection;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,Pipeline $pipeline): RecipeCollection
    {
        $recipes = $pipeline->send(Recipe::query())
            ->through([
                Search::class,
                Category::class,
                Ingredient::class,
            ])
            ->thenReturn();


        return new RecipeCollection($recipes->with("category")->with("ingredients.pivot.unit")->paginate($request->perPage ?? 10));
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
    public function show(Recipe $recipe)
    {
        return new RecipeResource($recipe);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recipe $recipe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recipe $recipe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe)
    {
        //
    }
}
