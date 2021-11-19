<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'image'=> $this->image,
            'title_la'=> $this->title_la,
            'title_en'=> $this->title_en,
            'des_la'=> $this->des_la,
            'des_en'=> $this->des_en
        ];
    }
}
