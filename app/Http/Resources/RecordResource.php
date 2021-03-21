<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'url' => $this->url(),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'default_search_available' => $this->default_search_available ? 1 : 0,
            'created_at' => $this->created_at
        ];
    }
}
