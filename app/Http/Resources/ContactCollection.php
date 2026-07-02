<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ContactCollection extends ResourceCollection
{
    public $collects = ContactResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
        ];
    }

    /**
     * Tambahkan metadata pagination ke dalam response.
     */
    public function with(Request $request): array
    {
        return [
            'meta' => [
                'total'        => $this->total(),
                'per_page'     => $this->perPage(),
                'current_page' => $this->currentPage(),
                'last_page'    => $this->lastPage(),
            ],
        ];
    }
}
