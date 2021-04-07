<?php

namespace App;

use App\Utilities\FilterBuilder;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meal extends Model
{
    use SoftDeletes;
    use Translatable;

    public $translatedAttributes = ['name', 'description', 'lang_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->using(MealTag::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class)->using(IngredientTag::class);
    }

    public function status()
    {
        if ($this->deleted_at) {
            return 'deleted';
        }
        return $this->created_at == $this->updated_at ? 'created' : 'modified';
    }

    public function scopeFilterBy($query, $filters)
    {
        $namespace = 'App\Utilities\MealFilters';
        $filter = new FilterBuilder($query, $filters, $namespace);

        return $filter->apply();
    }
}
