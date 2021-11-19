<?php

namespace App\Http\Livewire\Admin\ReceiveBranch;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Logistic\Logistic;
use App\Models\Logistic\LogisticDetail;
use App\Models\Logistic\LogisticDetailList;
use App\Models\Logistic\LogisticTransection;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction\CreateTraffic;
use DB;

class ViewReceiveBranchComponent extends Component
{

    public $code, $search, $traffic_id;

    public function render()
    {
        $shipout = '';
        if(!empty($this->code)){
            $traffic = CreateTraffic::where('trf_code', $this->code)->first();
            if(!empty($traffic)){
                $this->traffic_id = $traffic->id;
                // $logis = Logistic::orderBy('id','desc')->where('branch_id', '!=', auth()->user()->branchname->id)
                // ->where('trf_code',$traffic->id)->first();
                // if(!empty($logis)){
                    $shipout = LogisticDetail::where('sendto_unit', auth()->user()->branchname->id)
                    ->where('status','S')->where('trf_code', $traffic->id)->get();
                // }else{
                //     $this->emit('alert', ['type' => 'error', 'message' => 'ຂໍ້ມູນນີ້ບໍ່ມີໃນລະບົບ!']);
                // }
            }else{
                $this->emit('alert', ['type' => 'error', 'message' => 'ຂໍ້ມູນນີ້ບໍ່ມີໃນລະບົບ!']);
            }
        }
        //  $shipout = LogisticDetail::where('sendto_unit', auth()->user()->branchname->id)
        //             ->where('status','S')->where('rvcode',$this->code)->get();
        return view('livewire.admin.receive-branch.view-receive-branch-component',compact('shipout'))->layout('layouts.base');
    }

    public function accept($ids)
    {   
        $shipout = LogisticDetail::find($ids);

        $out = Logistic::find($shipout->lgt_id);

        $list = DB::table('logistic_detail_lists')->where('detail_id', $ids)->update(array('status' => 'F'));

        $shipDetail = DB::table('logistic_details')->where('id', $ids)->update(array('status' => 'F','user_receive'=>auth()->user()->id,'receive_date'=>date('Y-m-d h:i:s')));

        $details = LogisticDetail::select('id','lgt_id','rvcode','status')->where('id', $ids)->where('status', 'F')->get();
            foreach ($details as $key => $value) {

                $receive = DB::table('receive_transactions')->where('code', $value->rvcode)->update(array('status' => 'F'));

                $matter = DB::table('matterails')->where('receive_id', $value->rvcode)->update(array('status' => 'F'));
            }
        
        $this->emit('alert', ['type' => 'success', 'message' => 'ຍອມຮັບສຳເລັດ!']);
    }

    public function stockDetail($ids)
    {
        return redirect(route('admin.detail_shipout_stock', $ids));
    }

    //Receive Detail
    public function receiveDetail($id)
    {
        return redirect(route('admin.detail_receive_branch', $id));
    }

    public function receivePrint($id)
    {
        return redirect(route('admin.print_view_receive_branch', $id));
    }

}
