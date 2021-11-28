<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BillReceiveResource extends JsonResource
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
            'code'=> $this->receivename->code, 
            'cus_send'=> $this->receivename->customername_send->name, 
            'cus_send_phone'=> $this->receivename->customername_send->phone,
            'branch_send_code'=> $this->receivename->branch_sends->code, 
            'branch_send'=> $this->receivename->branch_sends->company_name_la,
            'branch_send_phone'=> $this->receivename->branch_sends->phone,  
            'cus_receive'=> $this->receivename->customername_receive->name, 
            'cus_receive_phone'=> $this->receivename->customername_receive->phone,
            'branch_receive'=> $this->receivename->branch_receive_name->company_name_la, 
            'branch_receive_phone'=> $this->receivename->branch_receive_name->phone, 
            'branch_receive_vilname'=> $this->receivename->branch_receive_name->villname->name, 
            'size' => $this->large + $this->height + $this->longs,
            'weigh' => $this->weigh,     
            'amount' => $this->amount,   
            'cod_amount' => $this->cod_amount,   
            'insur_amount' => $this->insur_amount,   
            'sum' => $this->amount + $this->cod_amount + $this->insur_amount,
            'created_date'=> date('d/m/Y h:i:s', strtotime($this->receivename->created_at)), 
        ];
    }
}
