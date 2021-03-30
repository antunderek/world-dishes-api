<?php

namespace App;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use Translatable;

    public $translatedAttributes = ['title', 'lang_id'];

    public function meals() {
        return $this->hasMany(Meal::class);
    }
}
