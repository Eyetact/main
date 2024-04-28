<?php

namespace App\Http\Resources;

use App\Models\Admin\Component;
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
         $categoryId = $this->category_id;
         $components = $this->mix_component ? json_decode($this->mix_component, true) : null;

         if ($categoryId && $components) {
             $response = [];

             foreach ($components as $component) {
                 $componentId = $component['id'];

                 $category_values = Component::where('id', $componentId)->first();

                 $compo_category = json_decode($category_values->compo_category, true);
                 // dd($compo_category);

                 $compo_category = array_combine(
                     array_map('intval', array_keys($compo_category)),
                     array_values($compo_category)
                 );

                 $minimum = 0; // Initialize minimum value
                 $maximum = 0; // Initialize maximum value

                 foreach ($compo_category as $item) {
                     if (isset($item['id']) && $item['id'] == $categoryId) {
                         $minimum = $item['minimum'];
                         $maximum = $item['maximum'];
                         break; // Exit the loop once the matching item is found
                     }
                 }

                 $response[] = [
                     'id' => $component['id'],
                     'name' => $component['name'],
                     'value' => $component['value'],
                     'minimum' => $minimum, // Add minimum value to the component
                     'maximum' => $maximum, // Add maximum value to the component
                 ];
             }

             return [
                 'id' => $this->id,
                 'name' => $this->mix_name,
                 'category_id' => $this->category_id,
                 'components' => $response,
             ];
         } else {
             return [
                 'id' => $this->id,
                 'name' => $this->mix_name,
                 'category_id' => $this->category_id,
                 'components' => $components,
             ];
         }
     }

    // public function toArray(Request $request): array
    // {



    //     return [

    //         'id' => $this->id,
    //         'name' => $this->mix_name,
    //         'category_id' => $this->category_id,
    //         // 'components' => json_decode($this?->mix_component, true),
    //         'components' => $this->mix_component ? json_decode($this->mix_component, true) : null,
    //         // 'component_set_id' => $this->components_set_id,


    //     ];
    // }
}
