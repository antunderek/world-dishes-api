<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class MealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $with = [];
        if ($request->has('with')) {
            $with = $this->getWithAsArray($request->with);
        }
        DB::connection()->enableQueryLog();

        $ar = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status(),
            'category' => $this->when(in_array('category', $with), new CategoryResource($this->category)),
            'tags' => $this->when(in_array('tags', $with), TagResource::collection($this->tags)),
            'ingredients' => $this->when(in_array('ingredients', $with), IngredientResource::collection($this->ingredients)),
        ];
        $queries = DB::getQueryLog();
        dd($queries);
        return $ar;
    }

    private function getWithAsArray($with) {
        return array_map('trim', (explode(',', $with)));
    }
}
