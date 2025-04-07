<?php

namespace App\Http\Resources\Task;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowAllResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->map(function ($item) {
                return ShowResource::make($item);
            }),
            'pagination' => [
                'total' => $this->total(),
                'count' => is_null($this->lastItem()) ? 0 : $this->lastItem(),
                'per_page' => (int) $this->perPage(),
                'current_page' => $this->currentPage(),
                'total_pages' => $this->lastPage(),
                'links' => $this->linkCollection(),
                'prev_page_url' => $this->previousPageUrl(),
                'next_page_url' => $this->nextPageUrl(),
            ],
        ];
    }
}
