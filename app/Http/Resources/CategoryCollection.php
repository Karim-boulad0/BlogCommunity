<?php

namespace App\Http\Resources;

use App\Http\Resources\CategoryResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{

    public function toArray($request)
    {
        return CategoryResource::collection($this->collection);
    }
}
