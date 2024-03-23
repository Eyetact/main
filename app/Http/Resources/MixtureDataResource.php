<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MixtureDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {



        return [

            'id' => $this->id,
            'name' => $this->mix_name,
            'category_id' => $this->category_id,
            'components' => json_decode($this->mix_component, true),
            // 'component_set_id' => $this->components_set_id,


        ];
    }
}
