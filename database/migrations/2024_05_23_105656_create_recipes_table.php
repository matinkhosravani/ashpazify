<?php

use App\Models\Category;
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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->integer("people");
            $table->string("image");
            $table->integer("prep_time");
            $table->integer("cook_time");
            $table->unsignedBigInteger("category_id");
            $table->json("instructions");
            $table->json("notes");
            $table->timestamps();

            $table->foreign('category_id')->references('id')
                ->on(Category::getTableName())->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
