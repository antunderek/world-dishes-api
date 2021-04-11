<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class IngredientMeal extends Pivot
{
    protected $table = 'ingredient_meal';
}
