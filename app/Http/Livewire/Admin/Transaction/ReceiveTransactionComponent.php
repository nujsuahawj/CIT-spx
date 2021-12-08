<?php

namespace App\Http\Livewire\Admin\Transaction;

use Livewire\Component;


use Livewire\WithPagination;
use App\Models\Transaction\ReceiveTransaction;
use App\Models\Transaction\Matterail;
use App\Models\Transaction\ListMatterail;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings\Branch;
use DB;

class ReceiveTransactionComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $hiddenId , $rv_code, $search,$search_by_date,$search_by_brc=0;

    public function render()
    {
        $branchid  = Auth()->user()->branchname->id;
        
        if(Auth()->user()->rolename->name == 'admin')
        {
            $branch = Branch::where('del',1)->get();
            if($this->search_by_brc==0){
              
                $receivetransaction=ReceiveTransaction::select('receive_transactions.*','bs.company_name_la as brs','br.company_name_la as brr','cs.name as css','cr.name as crr') 
                ->join('branches as bs','receive_transactions.branch_send','=','bs.id')
                ->join('branches as br','receive_transactions.branch_receive','=','br.id')
                ->join('customers as cs','receive_transactions.customer_send','=','cs.id')
                ->join('customers as cr','receive_transactions.customer_receive','=','cr.id')
                ->where(function($query){
                    $query->where('receive_transactions.code', 'like', '%' .$this->search. '%');
                 })->where('receive_transactions.valuedt', 'like', '%' .$this->search_by_date. '%')  
                 ->orderBy('receive_transactions.id','desc')->paginate(10);
            }
            else
            {
                $receivetransaction=ReceiveTransaction::select('receive_transactions.*','bs.company_name_la as brs','br.company_name_la as brr','cs.name as css','cr.name as crr') 
                ->join('branches as bs','receive_transactions.branch_send','=','bs.id')
                ->join('branches as br','receive_transactions.branch_receive','=','br.id')
                ->join('customers as cs','receive_transactions.customer_send','=','cs.id')
                ->join('customers as cr','receive_transactions.customer_receive','=','cr.id')
                ->where(function($query){
                    $query->where('receive_transactions.code', 'like', '%' .$this->search. '%');
                 })->where('receive_transactions.valuedt', 'like', '%' .$this->search_by_date. '%')
                 ->where('receive_transactions.branch_receive', 'like', '%' .$this->search_by_brc. '%')
                 ->orderBy('receive_transactions.id','desc')->paginate(10);

            }

        }
        else
        {
            $branch = Branch::where('id',$branchid)->get();
            $receivetransaction=ReceiveTransaction::select('receive_transactions.*','bs.company_name_la as brs','br.company_name_la as brr','cs.name as css','cr.name as crr') 
            ->join('branches as bs','receive_transactions.branch_send','=','bs.id')
            ->join('branches as br','receive_transactions.branch_receive','=','br.id')
            ->join('customers as cs','receive_transactions.customer_send','=','cs.id')
            ->join('customers as cr','receive_transactions.customer_receive','=','cr.id')
            ->where('receive_transactions.branch_send','=',$branchid,'or','receive_transactions.branch_receive','=',$branchid)
            ->where(function($query){
                $query->where('receive_transactions.code', 'like', '%' .$this->search. '%');
             })->where('receive_transactions.valuedt', 'like', '%' .$this->search_by_date. '%')
             ->orderBy('receive_transactions.id','desc')->paginate(10);

        }
       
        return view('livewire.admin.transaction.receive-transaction-component',compact('receivetransaction','branch'))->layout('layouts.base');
    }

    public function DetailReceive($ids)
    {
        return redirect(route('transaction.detail_receive_transaction',$ids));
    }

    public function showDestroy($ids)
    {
        $this->dispatchBrowserEvent('show-modal-delete');
        $singleData = ReceiveTransaction::find($ids);
        $this->hiddenId = $singleData->id;
        $this->rv_code = $singleData->code;
    }

    public function destroyReceiveTransaction($ids)
    {
        $this->dispatchBrowserEvent('hide-modal-delete');
        
        // $singleData = ReceiveTransaction::find($ids);
        // $mat = Matterail::where('receive_id', $singleData->code)->delete();
        // $list_mat = ListMatterail::where('rvcode', $singleData->code)->delete();
        // $singleData->delete();

        $receive = DB::table('receive_transactions')->where('code', $this->rv_code)->update(array('status' => 'RJ'));
        $mat = DB::table('matterails')->where('receive_id', $this->rv_code)->update(array('status' => 'RJ'));
        $list_mat = DB::table('list_matterails')->where('rvcode', $this->rv_code)->update(array('status' => 'RJ'));

        $log_detail = DB::table('logistic_details')->where('rvcode', $this->rv_code)->update(array('status' => 'RJ'));
        $log_detail_list = DB::table('logistic_detail_lists')->where('rvcode', $this->rv_code)->update(array('status' => 'RJ'));

        $this->emit('alert', ['type' => 'success', 'message' => 'ຍົກເລີກ!! ຂໍ້ມູນສຳເລັດ!']);
    }

    public function destroy()
    {
        $ids = $this->hiddenId;
        $vihicle = ReceiveTransaction::find($ids);
        $vihicle->delete();
        $this->dispatchBrowserEvent('hide-modal-delete');
        $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
    }
}
