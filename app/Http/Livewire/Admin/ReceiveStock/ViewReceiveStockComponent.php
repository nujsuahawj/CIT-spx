<?php

namespace App\Http\Livewire\Admin\ReceiveStock;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Logistic\Logistic;
use App\Models\Logistic\LogisticDetail;
use App\Models\Logistic\LogisticTransection;
use App\Models\Transaction\CreateTraffic;
use DB;

class ViewReceiveStockComponent extends Component
{

    public $search, $code, $traffic_id;

    public function render()
    {
        $shipout = '';
        if(!empty($this->code)){
            $traffic = CreateTraffic::where('trf_code', $this->code)->first();
            if(!empty($traffic)){
                $this->traffic_id = $traffic->id;
                $shipout = Logistic::orderBy('id','desc')->where('branch_id', '!=', auth()->user()->branchname->id)
                ->where('trf_code',$traffic->id)->where('status','S')->get();
            }else{
                $this->emit('alert', ['type' => 'error', 'message' => 'ຂໍ້ມູນນີ້ບໍ່ມີໃນລະບົບ!']);
            }
        }else{
            $this->emit('alert', ['type' => 'warning', 'message' => 'ກະລຸນາ ປ້ອນຂໍ້ມູນ!']);
        }
        
        return view('livewire.admin.receive-stock.view-receive-stock-component',compact('shipout'))->layout('layouts.base');
    }

    public function accept($ids)
    {
        $shipout = LogisticDetail::where('lgt_id',$ids)->get();
        // dd($shipout);
        $ship = Logistic::find($ids);
        $ship->status = 'ST';
        $ship->save();

        foreach ($shipout as $item) {

            $shipDetail = DB::table('logistic_details')->where('id', $item->id)->update(array('status' => 'ST','user_receive'=>auth()->user()->id,'receive_date'=>date('Y-m-d h:i:s')));

            $shipDetailList = DB::table('logistic_detail_lists')->where('detail_id',  $item->id)->update(array('status' => 'ST'));

            $details = LogisticDetail::select('id','lgt_id','rvcode','status')->where('id',  $item->id)->where('status', 'ST')->get();

                foreach ($details as $value) {

                    $receive = DB::table('receive_transactions')->where('code', $value->rvcode)->update(array('status' => 'ST'));

                    $matter = DB::table('matterails')->where('receive_id', $value->rvcode)->update(array('branch_receive'=>auth()->user()->branchname->id,'usr_receive'=>auth()->user()->id,'status' => 'ST'));
                       
                }
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
        return redirect(route('admin.detail_receive', $id));
    }

    public function receivePrint($id)
    {
        return redirect(route('admin.print_view_receive_stock', $id));
    }
}
