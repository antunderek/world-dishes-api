<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MealTag extends Pivot
{
    protected $table = 'meal_tag';
}
