<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    protected $guarded = [
        'id'
    ];

    use EagerLoadPivotTrait;
    use HasFactory;

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class)->using(IngredientRecipe::class)->withPivot('amount', 'unit_id');
    }
}
