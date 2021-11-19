<?php

namespace App\Http\Livewire\Admin\Sales;

use Livewire\Component;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\SaleTransection;
use App\Models\Exchange;
use App\Models\Payment;
use App\Models\Shipping;
use Carbon\Carbon;

class EditSaleComponent extends Component
{
    public $hidenId, $product_id, $qty, $price, $discount, $vat, $series_number, $power_number, $note;
    public $discount_all, $vat_all, $amount_all, $grand_total, $paid_all;

    public function mount($id)
    {
        $editsale = Sale::find($id);

        $sum_total = SaleDetail::where('sale_id', $id)->sum('total');

        $this->hidenId = $editsale->id;
        $this->discount_all = $editsale->discount;
        $this->vat_all = $editsale->vat;
        //$this->grand_total = $editsale->grand_total;
        //$this->grand_total = $sum_total;
        $this->grand_total = (((($sum_total - $editsale->discount)*$editsale->vat)/100)+($sum_total - $editsale->discount));
        $this->paid_all = $editsale->paid;
        $this->payment_id = 1;
        $this->shipping_id = 1;
        $this->customer_id = $editsale->customer_id;
    }

    public function render()
    {
        $sales = Sale::where('id', $this->hidenId)->get();
        $saleDetails = SaleDetail::where('sale_id', $this->hidenId)->get();
        $products = Product::orderBy('id','desc')->where('del',1)->get();
        $customer = Customer::where('del',1)->get();
        $payments = Payment::all();
        $shippings = Shipping::all();

        $sum_total_tran = SaleDetail::where('sale_id', $this->hidenId)->sum('total');
        $sum_total_qty = SaleDetail::where('sale_id', $this->hidenId)->sum('qty');
        $sum_total_price = SaleDetail::where('sale_id', $this->hidenId)->sum('price');
        $sum_total_discount = SaleDetail::where('sale_id', $this->hidenId)->sum('discount');
        $sum_total_amount = SaleDetail::where('sale_id', $this->hidenId)->sum('amount');

        $exchanges = Exchange::where('id',1)->first();

        return view('livewire.admin.sales.edit-sale-component',[
            'sales'=>$sales, 'saleDetails'=>$saleDetails, 'products'=>$products, 'customer'=>$customer,
            'sum_total_tran'=> $sum_total_tran, 'sum_total_qty'=>$sum_total_qty, 'sum_total_price'=>$sum_total_price,'sum_total_amount'=>$sum_total_amount,
            'exchanges'=>$exchanges, 'payments'=>$payments, 'shippings'=>$shippings
        ])->layout('layouts.base');
    }
    //App Product to list
    public function addTolist()
    {
        $sale = Sale::find($this->hidenId);
        $this->validate([
            'product_id'=>'required|unique:sale_transections'
        ],[
            'product_id.required'=>'ເລືອກສິນຄ້າກ່ອນ!',
        ]);
        $transection = SaleDetail::create([
            'sale_id'=> $this->hidenId,
            'sale_code'=> $sale->code,
            'product_id'=> $this->product_id,
            'qty'=> 1,
            'discount'=> 0,
            'vat'=> 0,
        ]);
        $transection->price = $transection->productname->sale_price;
        $transection->amount = ($transection->productname->sale_price - $transection->discount) * $transection->qty;
        $transection->total = (($transection->amount * $transection->vat)/100) + $transection->amount;
        $transection->save();
        $this->emit('alert', ['type' => 'success', 'message' => 'ເພີ່ມສິນຄ້າສຳເລັດ!']);
    }

    public function increment($id)
    {
        //dd($id);
        $transection = SaleDetail::find($id);
        $transection->update([
            'qty'=> $transection->qty+1,
            'amount'=> ($transection->price - $transection->discount) * ($transection->qty+1),
            'total'=> (((($transection->price - $transection->discount) * ($transection->qty+1)) * $transection->vat)/100) + (($transection->price - $transection->discount) * ($transection->qty+1))
        ]);

        $this->emit('alert', ['type' => 'success', 'message' => 'ເພີ່ມຈຳນວນສຳເລັດ!']);
    }
    public function decrement($id)
    {
        $transection = SaleDetail::find($id);
        $transection->update([
            'qty'=> $transection->qty-1,
            'amount'=> ($transection->price - $transection->discount) * ($transection->qty-1),
            'total'=> (((($transection->price - $transection->discount) * ($transection->qty-1)) * $transection->vat)/100) + (($transection->price - $transection->discount) * ($transection->qty-1))
        ]);

        $this->emit('alert', ['type' => 'success', 'message' => 'ລົບຈຳນວນສຳເລັດ!']);
    }
    //Update Price
    public function editPrice($ids)
    {
        $this->dispatchBrowserEvent('show-modal');

        $trans = SaleDetail::find($ids);

        $this->qty = $trans->qty;
        $this->price = $trans->price;
        $this->discount = $trans->discount;
        $this->vat = $trans->vat;
        $this->series_number = $trans->series_number;
        $this->power_number = $trans->power_number;
        $this->note = $trans->note;
        $this->hidenId = $trans->id;
    }
    public function updatePrice()
    {
        $updateId = $this->hidenId;
        $trans = SaleDetail::find($updateId);
        $trans->update([
            'qty'=>$this->qty,
            'price'=>$this->price,
            'discount'=>$this->discount,
            'amount'=> (($this->price - $this->discount) * $this->qty),
            'vat'=>$this->vat,
            'total'=> (((($this->price - $this->discount) * $this->qty) * $this->vat)/100) + (($this->price - $this->discount) * $this->qty),
            'series_number'=>$this->series_number,
            'power_number'=>$this->power_number,
            'note'=>$this->note
        ]);

        $this->emit('alert', ['type' => 'success', 'message' => 'ແກ້ໄຂຂໍ້ມູນສຳເລັດ!']);
        $this->dispatchBrowserEvent('close-modal');

    }
    //Delete form list
    public function showdeleteProlist($id)
    {
        $this->dispatchBrowserEvent('show-modal-delete');
        $trans = SaleDetail::find($id);
        $this->hidenId = $trans->id;
    }
    public function deleteProlist()
    {
        //dd($id);
        $updateId = $this->hidenId;
        $trans = SaleDetail::find($updateId);
        $trans->delete();
        $this->dispatchBrowserEvent('close-modal-delete');
        $this->emit('alert',['type' => 'success','message'=>'ລຶບລາຍການສິນຄ້າອອກສຳເລັດ!']);
    }
    //Exchange
    public $currency_one, $rate_one, $currency_two, $rate_two;
    public function editExchange($id)
    {
        $this->dispatchBrowserEvent('show-modal-exchange');
        $exchange = Exchange::find($id);

        $this->currency_one = $exchange->currency_one;
        $this->rate_one = $exchange->rate_one;
        $this->currency_two = $exchange->currency_two;
        $this->rate_two = $exchange->rate_two;
        $this->hidenId = $exchange->id;
    }
    public function updateExchange()
    {
        $updateId = $this->hidenId;
        $exchange = Exchange::find($updateId);
        $exchange->update([
            'currency_one'=>$this->currency_one,
            'rate_one'=>$this->rate_one,
            'currency_two'=>$this->currency_two,
            'rate_two'=>$this->rate_two
        ]);
        //dd($exchange);
        $this->emit('alert',['type'=>'success','message'=>'ແກ້ໄຂຂໍ້ມູນສຳເລັດ!']);
        $this->dispatchBrowserEvent('close-modal-exchange');
    }

    //Process Paid
    public $customer_id, $payment_id, $shipping_id;
    public function saveSale()
    {
        $sum_qty = SaleDetail::where('sale_id', $this->hidenId)->sum('qty');
        $sum_total = SaleDetail::where('sale_id', $this->hidenId)->sum('amount');

        $sale = Sale::find($this->hidenId);

        if($this->paid_all - $this->grand_total > 0)
        {
            $sale->debit = 0;
        }
        else
        {
            $sale->debit = $this->grand_total - $this->paid_all;
        }
        //Update ບໍ່ສາມາດ ບັນທຶກໄດ້ ຄັ້ງທຳອິດ
        $sale_data = [
            'customer_id'=> $this->customer_id,
            'sum_qty'=>$sum_qty,
            'sum_total'=>$sum_total,
            'discount'=>$this->discount_all,
            'vat'=>$this->vat_all,
            'grand_total'=>(((($sum_total - $this->discount_all) * $this->vat_all)/100) + ($sum_total - $this->discount_all)),
            'paid'=>$this->paid_all,
            'change_return' => ($this->paid_all - (((($sum_total - $this->discount_all) * $this->vat_all)/100) + ($sum_total - $this->discount_all))),
            //'debit'=> ((((($sum_total - $this->discount_all) * $this->vat_all)/100) + ($sum_total - $this->discount_all)) - $this->paid_all),
            'debit'=> $sale->debit,
            'payment_id'=>$this->payment_id,
            'shipping_id'=>$this->shipping_id,
            'note'=> $this->note,
            'user_id'=> auth()->user()->id,
        ];

        $sale->update($sale_data);

        /*
        $trans = SaleDetail::get();
        foreach ($trans as $key => $value) {
            $products = array(
                'sale_id'=>$sale->id,
                'sale_code'=>$sale->code,
                'product_id'=>$value->product_id,
                'qty'=>$value->qty,
                'price'=>$value->price,
                'discount'=>$value->discount,
                'amount'=>$value->amount,
                'vat'=>$value->vat,
                'total'=>$value->total,
                'series_number'=>$value->series_number,
                'power_number'=>$value->power_number,
                'note'=>$value->note,
                'created_at'=> \Carbon\Carbon::now(),
                'updated_at'=> \Carbon\Carbon::now()
            );
            
            $saleDetail = SaleDetail::insert($products);

            $deleteTrans = SaleDetail::where('id', $value->id)->delete();
        }
        */

        $this->emit('alert',['type'=>'success','message'=>'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
        //return redirect(route('admin.sale'));
        //dd($sale);
    }
}
