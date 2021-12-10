<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MaterailResource extends JsonResource
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
            'receive_id'=> $this->receive_id, 
            'goods_name'=> $this->goodname->name,
            'product_name'=> $this->productname->name, 
            'cal_type'=> $this->calculatename->name,
            'dist_name'=> $this->distantname->name,  
            'large'=> $this->large, 
            'height'=> $this->height,
            'longs'=> $this->longs, 
            'weigh'=> $this->weigh, 
            'amount'=> $this->amount, 
            'cod_amount'=> $this->cod_amount, 
            'insur_amount' => $this->insur_amount,
            'pack_name' => $this->packname->name,     
            'pack_amount' => $this->pack_amount,   
            'paid_by' => if($this->paid_by == sd){'ຕົ້ນທາງ'}else{'ປາຍທາງ'},   
            'branch_id' => $this->insur_amount,   
        ];
    }
}
