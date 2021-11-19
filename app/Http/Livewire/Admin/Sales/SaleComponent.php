<?php

namespace App\Http\Livewire\Admin\Sales;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Customer;


class SaleComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $hidenId, $from_date, $search, $customer_id;

    public function render()
    {
        $customers = Customer::where('del',1)->get();

        $sales = Sale::orderBy('id','desc')
            ->where('code','like', '%' .$this->search. '%')
            ->where('customer_id', 'like', '%' .$this->customer_id . '%')
            ->where('created_at', 'like', '%' .$this->from_date. '%')
            ->where('del',1)->paginate(10);

        return view('livewire.admin.sales.sale-component', compact('sales','customers'))->layout('layouts.base');
    }

    public function editSale($id)
    {
        //dd($id);
        $sales = Sale::find($id);
        return redirect(route('admin.edit_sale',$id));
    }
    public function showDelete($id)
    {
        $this->dispatchBrowserEvent('show-modal-delete');
        $sale = Sale::find($id);
        $this->hidenId = $sale->id;
        if($sale->debit > 0)
        {
            $this->emit('alert',['type' => 'warning','message'=>'ບໍ່ສາມາລຶບລາຍການຂາຍນີ້ໄດ້ ເພາະຍັງເປັນໜີ້ຢູ່! ກະລຸນາກວດຄືນໃໝ່!']);
            $this->dispatchBrowserEvent('close-modal-delete');
        }
    }
    public function deleteSale()
    {
        $deleteId = $this->hidenId;
        $sale = Sale::find($deleteId);
        if($sale->debit <= 0)
        {
            $saleDetail = SaleDetail::where('sale_id',$deleteId)->delete();
            $sale->delete();
            $this->emit('alert',['type' => 'success','message'=>'ລຶບລາຍການຂາຍ ແລະ ລາຍລະອຽດສິນຄ້າອອກສຳເລັດ!']);
            $this->dispatchBrowserEvent('close-modal-delete');
        }else
        {
            $this->emit('alert',['type' => 'warning','message'=>'ບໍ່ສາມາລຶບລາຍການຂາຍນີ້ໄດ້ ເພາະຍັງເປັນໜີ້ຢູ່! ກະລຸນາກວດຄືນໃໝ່!']);
            $this->dispatchBrowserEvent('close-modal-delete');
        }
    }
    //Sale Detail
    public function saleDetail($id)
    {
        $sale = Sale::find($id);
        return redirect(route('admin.sale_detail', $id));
    }
    //Print sale
    public function printA4Sale($id)
    {
        $sale = Sale::find($id);
        return redirect(route('admin.printa4_sale', $id));
    }
}
