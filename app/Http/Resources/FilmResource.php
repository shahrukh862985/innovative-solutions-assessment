<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FilmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'release_date' => date("F j, Y",strtotime($this->release_date)),
            'rating' => $this->rating,
            'price' => $this->price,
            'country' => $this->country,
            'genre' => json_decode($this->genre),
            'photo' => $this->file_path,
            'created_at' => date("F j, Y",strtotime($this->created_at)),
            'comments' => CommentResource::collection($this->whenLoaded('comments'))
        ];
    }
}
