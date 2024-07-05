<?php

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Unit;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ingredient_recipe', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('ingredient_id');
            $table->unsignedBiginteger('recipe_id');
            $table->unsignedBiginteger('unit_id');
            $table->integer('amount');



            $table->foreign('recipe_id')->references('id')
                ->on(Recipe::getTableName())->onDelete('cascade');
            $table->foreign('ingredient_id')->references('id')
                ->on(Ingredient::getTableName())->onDelete('cascade');
            $table->foreign('unit_id')->references('id')
                ->on(Unit::getTableName())->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredient_recipe');
    }
};
