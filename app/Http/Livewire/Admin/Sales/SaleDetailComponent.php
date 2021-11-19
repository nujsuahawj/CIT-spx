<?php

namespace App\Http\Livewire\Admin\Sales;

use Livewire\Component;
use App\Models\SaleDetail;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Exchange;

class SaleDetailComponent extends Component
{
    public $hidenId;

    public function mount($id)
    {
        $sales = Sale::find($id);

        $this->hidenId = $sales->id;
    }
    public function render()
    {
        $sales = Sale::where('id', $this->hidenId)->first();
        $saleDetails = SaleDetail::where('sale_id', $this->hidenId)->get();
        $exchanges = Exchange::where('id',1)->first();
        
        $sum_qty_sale_detail = SaleDetail::select('sale_id','qty')->where('sale_id', $this->hidenId)->sum('qty');
        $sum_price_sale_detail = SaleDetail::select('sale_id','price')->where('sale_id', $this->hidenId)->sum('price');
        $sum_discount_sale_detail = SaleDetail::select('sale_id','discount')->where('sale_id', $this->hidenId)->sum('discount');
        $sum_amount_sale_detail = SaleDetail::select('sale_id','amount')->where('sale_id', $this->hidenId)->sum('amount');
        $sum_total_sale_detail = SaleDetail::select('sale_id','total')->where('sale_id', $this->hidenId)->sum('total');

        return view('livewire.admin.sales.sale-detail-component', compact('sales','saleDetails','sum_qty_sale_detail','sum_price_sale_detail','sum_discount_sale_detail',
        'sum_amount_sale_detail','sum_total_sale_detail','exchanges'))->layout('layouts.base');
    }
}
