<?php

namespace App\Http\Controllers;

use App\Filters\Ingredient\Search;
use App\Filters\Ingredient\Sort;
use App\Http\Resources\IngredientCollection;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class IngredientController extends Controller
{
    public function index(Request $request,Pipeline $pipeline)
    {
        $ingredients = $pipeline->send(Ingredient::query())
            ->through([
                Search::class,
                Sort::class,
            ])
            ->thenReturn();


        return $ingredients->paginate($request->perPage ?? 10);
    }

    public function all(Request $request,Pipeline $pipeline)
    {
        $ingredients = $pipeline->send(Ingredient::query())
            ->through([
                Search::class,
                Sort::class,
            ])
            ->thenReturn();


        return $ingredients->get();
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
    public function show(Ingredient $ingredient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ingredient $ingredient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ingredient $ingredient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ingredient $ingredient)
    {
        //
    }
}
