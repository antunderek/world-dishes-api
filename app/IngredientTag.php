<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class IngredientTag extends Pivot
{
    protected $table = 'ingredient_meal';

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($item) {
            if ($item->pivotParent->ingredients->count() == 1) {
                $item->pivotParent->forceDelete();
            }
        });
    }
}
