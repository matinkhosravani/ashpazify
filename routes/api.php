<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RecipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/recipes', [RecipeController::class , 'index']);
Route::get('/recipes/{recipe}', [RecipeController::class , 'show']);
Route::get('/ingredients', [IngredientController::class , 'index']);
Route::get('/ingredients/all', [IngredientController::class , 'all']);
Route::get('/categories', [CategoryController::class , 'index']);
Route::get('/categories/all', [CategoryController::class , 'all']);
