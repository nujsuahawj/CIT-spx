<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SearchReceiveResource extends JsonResource
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
            'id'=>$this->id,
            'code'=>$this->code,
            'valuedt'=>$this->valuedt,
            'name'=>$this->crr,
            'phone'=>$this->crphone,
            'status'=>$this->status,
        ];
    }
}
