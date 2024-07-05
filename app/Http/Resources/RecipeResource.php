<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'people' => $this->people,
            'image' => $this->image,
            'prep_time' => $this->prep_time,
            'cook_time' => $this->cook_time,
            'instructions' => $this->instructions,
            'notes' => $this->notes,
            'category' => new CategoryResource($this->category),
            'ingredients' => IngredientResource::collection($this->ingredients)
        ];
    }
}
