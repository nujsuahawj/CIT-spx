<?php

namespace App\Http\Livewire\Admin\Purchase;

use Livewire\Component;
use App\Models\Member;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\PurchasesTransection;
use App\Models\Exchange;
use App\Models\Payment;

class CreatePurchaseComponent extends Component
{
    public $hiddenId, $product_id, $qty, $buying_price, $discount, $vat , $member_id, $discount_all, $amount_all, $vat_all, $grand_total,
    $paid_all, $payment_id, $note;

    public function mount()
    {
        $this->payment_id = 1; $this->discount_all = 0; $this->vat = 0;
    }

    public function render()
    {
        $products = Product::select('id','code','name','buy_price','del')->orderBy('id','desc')->where('del',1)->get();
        $members = Member::select('id','firstname','lastname','phone','branch_id','del')->orderBy('id','desc')->where('del',1)->where('branch_id', auth()->user()->branchname->id)->get();
        $transection = PurchasesTransection::all()->where('user_id', auth()->user()->id);
        $exchanges = Exchange::first();
        $payment_status = Payment::all();

        $sum_total_qty = PurchasesTransection::select('qty','user_id')->where('user_id', auth()->user()->id)->sum('qty');
        $sum_total_price = PurchasesTransection::select('buying_price','user_id')->where('user_id', auth()->user()->id)->sum('buying_price');
        $sum_total_discount = PurchasesTransection::select('discount','user_id')->where('user_id', auth()->user()->id)->sum('discount');
        $sum_amount = PurchasesTransection::select('amount','user_id')->where('user_id', auth()->user()->id)->sum('amount');

        return view('livewire.admin.purchase.create-purchase-component', compact('products','members','transection','exchanges','payment_status','sum_total_qty','sum_total_price','sum_total_discount','sum_amount'))
        ->layout('layouts.base');
    }
    //Reset Filed
    public function resetField()
    {
        $this->discount = '';
        $this->vat = '';
        $this->note = '';
    }
    //Add product to list
    public function addProduct()
    {
        if($this->product_id == null)
        {
            $this->emit('alert', ['type'=>'warning','message'=>'ກະລຸນາເລືອກສິນຄ້າກ່ອນ!']);
        }
        /*
        elseif (PurchasesTransection::where('product_id', $this->product_id)->exists() && PurchasesTransection::where('user_id', auth()->user()->id)) 
        {
            $this->emit('alert', ['type'=>'warning','message'=>'ສິນຄ້ານີ້ໄດ້ເພີ່ມແລ້ວ! ກະລຸນາເພີ່ມຈຳນວນເອົາ!']);
        }*/
        else
        {
            $transection = PurchasesTransection::create([
                'product_id'=> $this->product_id,
                'qty'=> 1,
                'discount'=> 0,
                'user_id'=> auth()->user()->id,
                'branch_id'=> auth()->user()->branchname->id
            ]);
            $transection->unit = $transection->productname->unit;
            $transection->buying_price = $transection->productname->buy_price;
            $transection->vat = $transection->productname->vat;
            $transection->amount = (((($transection->buying_price - $transection->discount) * $transection->qty) * $transection->vat/100) + ($transection->buying_price - $transection->discount));
            $transection->save();
            $this->emit('alert',['type'=>'success', 'message'=>'ເພີ່ມລາຍການສິນຄ້າສຳເລັດ!']);
        }
    }
    //ເພີ່ມ ແລະ ລົບຈຳນວນ
    public function increment($id)
    {
        $transection = PurchasesTransection::find($id);
        $transection->update([
            'qty' => $transection->qty + 1,
            'amount'=> (((($transection->buying_price - $transection->discount) * ($transection->qty+1)) * $transection->vat)/100) + (($transection->buying_price - $transection->discount) * ($transection->qty+1))
        ]);
        $this->emit('alert', ['type' => 'success', 'message' => 'ເພີ່ມຈຳນວນສຳເລັດ!']);
    }
    public function decrement($id)
    {
        $transection = PurchasesTransection::find($id);
        $transection->update([
            'qty' => $transection->qty - 1,
            'amount'=> (((($transection->buying_price - $transection->discount) * ($transection->qty-1)) * $transection->vat)/100) + (($transection->buying_price - $transection->discount) * ($transection->qty-1))
        ]);
        $this->emit('alert', ['type' => 'success', 'message' => 'ລົບຈຳນວນສຳເລັດ!']);
    }
    //ແກ້ໄຂລາຄາ
    public function showeditPrice($id)
    {
        $this->resetField();
        $this->dispatchBrowserEvent('show-modal-edit-price');
        $transection = PurchasesTransection::find($id);
        $this->hiddenId = $transection->id;
        $this->qty = $transection->qty;
        $this->buying_price = $transection->buying_price;
        $this->discount = $transection->discount;
        $this->vat = $transection->vat;

    }
    public function editPrice()
    {
        $transection = PurchasesTransection::find($this->hiddenId);
        $transection->update([
            'qty'=> $this->qty,
            'buying_price'=> $this->buying_price,
            'discount'=>$this->discount,
            'vat'=>$this->vat,
            'sub_amount'=> ((($this->qty * ($this->buying_price - $this->discount)) * $this->vat)/100) + ($this->qty * ($this->buying_price - $this->discount))
        ]);
        $this->dispatchBrowserEvent('hide-modal-edit-price');
        $this->emit('alert', ['type'=>'success','message'=>'ແກ້ໄຂຂໍ້ມູນສຳເລັດ!']);
    }
    //Show and delete Product from list
    public function showdeleteProduct($id)
    {
        $this->dispatchBrowserEvent('show-modal-product-list');
        $transection = PurchasesTransection::find($id);
        $this->hiddenId = $transection->id;
    }
    public function deleteProduct()
    {
        $transection = PurchasesTransection::find($this->hiddenId);
        $transection->delete();
        $this->dispatchBrowserEvent('hide-modal-product-list');
        $this->emit('alert', ['type' => 'success', 'message' => 'ເພີ່ມຂໍ້ມູນສຳເລັດ!']);
    }
    //Show and edit Exchange
    public $currency_one, $rate_one, $currency_two, $rate_two;
    public function showeditExchange($id)
    {
        $this->dispatchBrowserEvent('show-modal-edit-exchange');
        $exchanges = Exchange::where('id',1)->first();
        $this->currency_one= $exchanges->currency_one;
        $this->rate_one= $exchanges->rate_one;
        $this->currency_two= $exchanges->currency_two;
        $this->rate_two = $exchanges->rate_two;
        $this->hiddenId = $exchanges->id;
    }
    public function updateExchange()
    {
        $exchanges = Exchange::find($this->hiddenId);
        $exchanges->update([
            'currency_one' => $this->currency_one,
            'rate_one' => $this->rate_one,
            'rate_two' => $this->rate_two,
            'currency_two' => $this->currency_two,
        ]);
        $this->dispatchBrowserEvent('hide-modal-edit-exchange');
        $this->emit('alert', ['type' => 'success', 'message' => 'ແກ້ໄຂຂໍ້ມູນສຳເລັດ!']);
    }

    //Save 
    
    public function savePurchase()
    {
        $sum_total_qty = PurchasesTransection::select('qty','user_id')->where('user_id', auth()->user()->id)->sum('qty');
        $sum_total_price = PurchasesTransection::select('buying_price')->where('user_id', auth()->user()->id)->sum('buying_price');
        $sum_total_discount = PurchasesTransection::select('discount')->where('user_id', auth()->user()->id)->sum('discount');
        $sum_total_amount = PurchasesTransection::select('amount')->where('user_id', auth()->user()->id)->sum('amount');

        if($this->member_id == null)
        {
            $this->emit('alert', ['type'=>'warning','message'=>'ເລືອກສະມາຊິກ່ອນ']);
        }
        else
        {
            $purchase = new Purchase(); 
            $purchase->code = 'PO'.date('Ymdhms');
            $purchase->member_id = $this->member_id;
            $purchase->total_qty = $sum_total_qty;
            $purchase->discount_all = $this->discount_all;
            $purchase->vat = $this->vat_all;
            //$purchase->paid = $this->paid_all;
            if($this->paid_all > $sum_total_amount)
            {
                $purchase->paid =  $sum_total_amount;
            }else
            {
                $purchase->paid = $this->paid_all;
            }
            //$purchase->total_return = ($this->paid_all - (((($sum_sub_amount - $this->discount_all) * $this->vat_all)/100)+($sum_sub_amount - $this->discount_all)));
            $purchase->grand_total = (((($sum_total_amount - $this->discount_all) * $this->vat_all)/100)+($sum_total_amount - $this->discount_all));
            //$purchase->status = $this->process_status_id;
            $purchase->payment_id = $this->payment_id;
            $purchase->user_id = auth()->user()->id;
            $purchase->branch_id = auth()->user()->branchname->id;
            $purchase->note = $this->note;
            
            if($purchase->debit = $this->paid_all - $sum_total_amount > 0)
            {
                $purchase->debit = 0;
            }
            else
            {
                $purchase->debit = $sum_total_amount - $this->paid_all;
            }
            $purchase->save();

            $trans = PurchasesTransection::get();
            foreach($trans as $key => $value){
                $products = array(
                    'purchases_id' => $purchase->id,
                    'product_id'=> $value->product_id,
                    'qty' => $value->qty,
                    'unit' => $value->unit,
                    'buying_price' => $value->buying_price,
                    'discount' => $value->dicount,
                    'amount'=> $value->amount,
                    'vat' => $value->vat,
                    //'total' => $value->total,
                    'note'=> $value->note
                );
                $purchaseDetail = PurchaseDetail::insert($products);

                $deleteTrans = PurchasesTransection::where('id', $value->id)->where('user_id', auth()->user()->id)->delete();
            }
            return redirect(route('admin.purchase'));
        }
    }
}
