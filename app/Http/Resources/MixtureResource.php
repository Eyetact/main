<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MixtureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

         // Decode the 'set_component' JSON data
         $decodedComponents = json_decode($this->mix_component, true);

         // Extract the 'name' and 'index' attributes from the JSON
         $components = collect($decodedComponents)->map(function ($item) {

             $name = isset($item['name']) ? $item['name'] : null;
             $value = isset($item['value']) ? $item['value'] : null;


             return [

                 'name' => $name,
                 'value'=> $value,
             ];
         });


        return [

            'id' => $this->id,
            'name' => $this->mix_name,
            'category_id' => $this->category_id,
            'components' => $components,
            'component_set_id' => $this->components_set_id,


        ];
    }
}
