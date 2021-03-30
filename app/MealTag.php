<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MealTag extends Pivot
{
    protected $table = 'meal_tag';

    public static function boot() {
        parent::boot();

        static::deleting(function($item) {
            if ($item->pivotParent->tags->count() == 1) {
                $item->pivotParent->forceDelete();
            }
        });
    }
}
