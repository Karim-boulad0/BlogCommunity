<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        // dd($request);
        $data = [
            'logo' => asset($this->logo),
            'favicon' => asset($this->favicon),
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'content' => $this->content,
            'title' => $this->title,
            'phone' => $this->phone,
            'created_at' => $this->created_at->format('Y-M-D'),
        ];
        return $data;
        // return $this->resource;// byrj3lna kl ldata
    }
}
