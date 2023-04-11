<?php

namespace App\Http\Resources;

use App\Http\Resources\PostResource;
use App\Http\Resources\CategoryCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'image' => asset($this->image),
            'parent' => $this->parent,
            'content' => $this->content,
            'title' => $this->title,
            'created_at' => $this->created_at->format('Y-M-D'),
            'deleted_at' => $this->created_at->format('Y-M-D'),
            'updated_at' => $this->created_at->format('Y-M-D'),
            // 'children' => CategoryCollection::make($this->children),
            'children' => CategoryCollection::make($this->whenLoaded('children')),
            'posts' => PostResource::collection($this->whenLoaded('posts')),
        ];
        return $data;
    }
}
