<?php

namespace App\Http\Resources;
use App\Http\Resources\UserResources;
use App\Http\Resources\VihicleTypeResoucres;
use App\Models\Condition\VihicleType;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CallGoodsResource extends JsonResource
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
            'id'=> $this->id,
            'code'=> $this->code,
            'vihicle_type_id'=> $this->vihicle_type_id,
            'goods_types_id'=>$this->goods_types_id,
            'product_type_id'=>$this->product_type_id,
            'longitude'=>$this->longitude,
            'latitude'=>$this->latitude,
            'product_count'=>$this->product_count,
            'large'=>$this->large,
            'height'=>$this->height,
            'longs'=>$this->longs,
            'weight'=>$this->weight,
            'detal'=>$this->detal,
            'appoinment_time'=>$this->appoinment_time,
            'status'=>$this->status,
            'note'=>$this->note,
            'user_id'=>$this->user_id,        
        ];
    }
}
