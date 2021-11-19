<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReceiveResource extends JsonResource
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
            // 'branch_send'=> $this->branch_send,
            // 'customer_send'=> $this->customer_send,
            // 'branch_receive'=> $this->branch_receive,
            'customer_receive'=> $this->customer_receive,
            'pro_id'=> $this->pro_id,
            'dis_id'=> $this->dis_id,
            'vil_id'=> $this->vil_id,
            // 'amount'=> $this->amount,
            // 'image'=> $this->image,
            'creator_id'=> $this->creator_id,
            'name'=>$this->name,
            'phone' => $this->phone,
            'goods_type_id' => $this->goods_id,
            'product_type_id' => $this->product_type_id,
            'weigh' => $this->weigh,
            'large' => $this->large,
            'height' => $this->height,
            'longs' => $this->longs,
            'weigh' => $this->weigh,
            'status'=> $this->ms,
            // 'branch_create_id'=> $this->branch_create_id,
            'note'=> $this->note,
            // 'status'=> $this->status,      
           ];
    }
}
