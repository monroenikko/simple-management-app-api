<?php

namespace App\Http\Resources\Task;

use App\Http\Resources\ImageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'title' => $this['title'],
            'content' => $this['content'],
            'is_published' => $this['is_published'],
            'is_draft' => $this['is_draft'],
            'status_id' => $this['status_id'],
            'status' => $this->status,
            'user' => $this->user,
            'images' => ImageResource::collection($this->images),
        ];
    }
}
