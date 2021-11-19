<?php

namespace App\Http\Livewire\Admin\PayDevidend;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Transaction\Paydevidends;
use App\Models\Transaction\Matterail;
use App\Models\Settings\Branch;
use Carbon\Carbon;
use DB;

class PayDevidendComponent extends Component
{
    use WithFileUploads;
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';

    public $search, $hiddenId;

    public function mount()
    {
       $pay = Paydevidends::orderBy('id','desc')->where('branch_id', auth()->user()->branchname->id)->first();
       if(!empty($pay)){
        $this->hiddenId = $pay->id;
       }
    }

    public function render()
    {
        $mat = Matterail::orderBy('id','desc')->where('branch_id', auth()->user()->branchname->id)->where('status','!=','RJ')->where('status_pay_devidend', 1)->paginate(10);
        $sum_mat = Matterail::where('branch_id', auth()->user()->branchname->id)->where('status','!=','RJ')->where('status_pay_devidend', 1)->sum('amount');
        if(!empty($this->search)){
            $pay = Paydevidends::orderBy('id','desc')->where('branch_id', auth()->user()->branchname->id)
            ->where('created_at', 'like', '%' .$this->search. '%')->paginate(10);
        }else{
            $pay = Paydevidends::orderBy('id','desc')->where('branch_id', auth()->user()->branchname->id)->paginate(10);
        }
        
        return view('livewire.admin.pay-devidend.pay-devidend-component',compact('mat','pay','sum_mat'))->layout('layouts.base');
    }

    public function devidend()
    {
        $count_mat = Matterail::where('branch_id', auth()->user()->branchname->id)->where('status','!=','RJ')->where('status_pay_devidend', 1)->count('id');
        if(!empty($count_mat)){
            $sum_mat = Matterail::where('branch_id', auth()->user()->branchname->id)->where('status','!=','RJ')->where('status_pay_devidend', 1)->sum('amount');
            $branch = Branch::find(auth()->user()->branchname->id);
                $devidend = $branch->dividendname->percent / 100;
                $vat = $branch->taxname->percent / 100;
            $pay = new Paydevidends;
            $pay->count = $count_mat;
            $pay->amount = $sum_mat;
            $pay->devidend = $branch->dividendname->percent;
            $pay->vat = $branch->taxname->percent;
            $pay->money = ($sum_mat*$devidend)-(($sum_mat*$devidend)*$vat);
            $pay->branch_id = auth()->user()->branchname->id;
            $pay->user_id = auth()->user()->id;
            $pay->created_at = \Carbon\Carbon::now();
            $pay->updated_at = \Carbon\Carbon::now();
            $pay->save();
    
            $mat = DB::table('matterails')->where('branch_id', auth()->user()->branchname->id)->where('status','!=','RJ')->where('status_pay_devidend', 1)->update(array('status_pay_devidend' => 0));
    
            $this->hiddenId = $pay->id;
            
            $this->emit('alert', ['type' => 'success', 'message' => 'ເບີກເງິນປັນຜົນສຳເລັດ!']);
        }else{
            $this->emit('alert', ['type' => 'error', 'message' => 'ຂໍອິໄພ!! ບໍ່ມີຂໍ້ມູນທີ່ທ່ານຕ້ອງການ!']);
        }
        
    }

    public function showreport($id)
    {

            $pay = Paydevidends::orderBy('id','desc')->where('branch_id', auth()->user()->branchname->id)->first();
            return redirect(route('admin.report_pay_devidend',$id));
        
    }
}
