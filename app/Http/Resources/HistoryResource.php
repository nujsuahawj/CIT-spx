<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HistoryResource extends JsonResource
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
            'cus_send'=> $this->customername_send->name, 
            'cus_send_phone'=> $this->customername_send->phone,
            'branch_send_code'=> $this->branch_sends->code, 
            'branch_send'=> $this->branch_sends->company_name_la,
            'branch_send_phone'=> $this->branch_sends->phone,  
            'cus_receive'=> $this->customername_receive->name, 
            'cus_receive_phone'=> $this->customername_receive->phone,
            'branch_receive_code'=> $this->branch_receive_name->code, 
            'branch_receive'=> $this->branch_receive_name->company_name_la, 
            'branch_receive_phone'=> $this->branch_receive_name->phone, 
            'branch_receive_vilname'=> $this->branch_receive_name->villname->name, 
            'amount' => $this->amount,   
            'cod_amount' => $this->cod_amount,   
            'insur_amount' => $this->insur_amount,   
            'pack_amount' => $this->pack_amount,   
            'sum' => $this->amount + $this->pack_amount + $this->cod_amount + $this->insur_amount,
            'created_date'=> date('d/m/Y H:i:s', strtotime($this->created_at)), 
        ];
    }
}
