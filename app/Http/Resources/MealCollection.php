<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MealCollection extends ResourceCollection
{
    private $metaData;
    private $links;

    public function __construct($resource)
    {
        $this->metaData = [
            'currentPage' => $resource->currentPage(),
            'totalItems' => $resource->total(),
            'itemsPerPage' => $resource->perPage(),
            'totalPages' => $resource->lastPage()
        ];

        $this->links = [
            'prev' => $resource->previousPageUrl(),
            'next' => $resource->nextPageUrl(),
            'self' => $resource->url($resource->currentPage()),
        ];

        $resource = $resource->getCollection();
        parent::__construct($resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //dd($this->resource);
        return [
            'meta' => $this->metaData,
            'data' => MealResource::collection($this->collection),
            'links' => $this->links,
        ];
    }
}
