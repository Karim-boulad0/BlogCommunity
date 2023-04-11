<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'image' => asset($this->image),
            'content' => $this->content,
            'title' => $this->title,
            'smallDesc' => $this->smallDesc,
            'tags' => $this->tags,
            'created_at' => $this->created_at->format('Y-M-D'),
            'deleted_at' => $this->created_at->format('Y-M-D'),
            'updated_at' => $this->created_at->format('Y-M-D'),
            'writer' => $this->whenLoaded('user'),
            'category' => CategoryResource::make($this->whenLoaded('category')),
        ];
        return $data;
    }
}
