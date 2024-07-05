<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Recipe extends Model
{
    use HasFactory;

    protected $casts = [
        'instructions' => 'array',
        'notes' => 'array'
    ];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class)->withPivot('amount', 'unit_id')->using(IngredientRecipe::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


}
