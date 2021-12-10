<?php

namespace App\Http\Livewire\Admin\ReceiveStock;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Logistic\Logistic;
use App\Models\Logistic\LogisticDetail;
use App\Models\Logistic\LogisticDetailList;
use App\Models\Logistic\LogisticTransection;
use App\Models\Transaction\CreateTraffic;
use Carbon\Carbon;
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
                ->where('trf_code',$traffic->id)->where('status','S')->where('del', 1)->get();
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
        $logistic = Logistic::where('id',$ids)->get();
        foreach($logistic as $item)
        {
            $list = array(
                'code'=>$item->code,
                'trf_code'=>$item->trf_code,
                'create_date'=>date('Y-m-d h:i:s'),
                'user_create'=> auth()->user()->id,
                'branch_id'=>auth()->user()->branchname->id,
                'status'=>'ST',
                'del'=>1,
                'created_at'=> \Carbon\Carbon::now(),
                'updated_at'=> \Carbon\Carbon::now()
            ); 
            $logistics = Logistic::insert($list);
        }

        $logistic_detail = LogisticDetail::where('lgt_id',$ids)->get();
        foreach($logistic_detail as $item)
        {
            $list = array(
                'lgt_id'=>$item->id,
                'trf_code'=>$item->trf_code,
                'rvcode'=>$item->rvcode,
                'sender_unit'=>$item->sender_unit,
                'user_unit'=>$item->user_unit,
                'add_date'=>$item->add_date,
                'sendto_unit'=>$item->sendto_unit,
                'status'=>'ST',
                'del'=>1,
                'branch_id'=>auth()->user()->branchname->id,
                'created_at'=> \Carbon\Carbon::now(),
                'updated_at'=> \Carbon\Carbon::now()
            ); 
            $logistic_details = LogisticDetail::insert($list);
        }

        
        $logistic_detail_list = LogisticDetailList::where('lgt_id',$ids)->get();
        foreach($logistic_detail_list as $item)
        {
            $list = array(
                'lgt_id'=>$item->lgt_id,
                'trf_code'=>$item->trf_code,
                'detail_id'=>$item->detail_id,
                'rvcode'=>$item->rvcode,
                'code'=>$item->code,
                'good_id'=>$item->good_id,
                'product_type_id'=>$item->product_type_id,
                'large'=>$item->large,
                'height'=>$item->height,
                'longs'=>$item->longs,
                'weigh'=>$item->weigh,
                'amount'=>$item->amount,
                'paid_type'=>$item->paid_type,
                'sendto_unit'=>$item->sendto_unit,
                'user_id'=>Auth()->user()->id,
                'branch_id'=>Auth()->user()->branchname->id,
                'status'=>'ST',
                'del'=>1,
                'created_at'=> \Carbon\Carbon::now(),
                'updated_at'=> \Carbon\Carbon::now()
            ); 
            $logistic_detail_list = LogisticDetailList::insert($list);
        }
        $ship = DB::table('logistics')->where('id',  $ids)->update(array('del' =>0));
        $shipDetail = DB::table('logistic_details')->where('lgt_id', $ids)->update(array('del' =>0,'user_receive'=>auth()->user()->id,'receive_date'=>date('Y-m-d h:i:s')));
        $shipDetailList = DB::table('logistic_detail_lists')->where('lgt_id',  $ids)->update(array('del' =>0));

        $logistic_code = LogisticDetail::where('lgt_id',$ids)->first();
        $receive = DB::table('receive_transactions')->where('code', $logistic_code->rvcode)->update(array('status' => 'ST'));
        $matter = DB::table('matterails')->where('receive_id', $logistic_code->rvcode)->update(array('branch_receive'=>auth()->user()->branchname->id,'usr_receive'=>auth()->user()->id,'status' => 'ST'));
        
        // dd($shipout);
        // $ship = Logistic::find($ids);
        // $ship->status = 'ST';
        // $ship->save();

        // foreach ($shipout as $item) {

        //     $shipDetail = DB::table('logistic_details')->where('id', $item->id)->update(array('status' => 'ST','user_receive'=>auth()->user()->id,'receive_date'=>date('Y-m-d h:i:s')));

        //     $shipDetailList = DB::table('logistic_detail_lists')->where('detail_id',  $item->id)->update(array('status' => 'ST'));

        //     $details = LogisticDetail::select('id','lgt_id','rvcode','status')->where('id',  $item->id)->where('status', 'ST')->get();

        //         foreach ($details as $value) {

        //             $receive = DB::table('receive_transactions')->where('code', $value->rvcode)->update(array('status' => 'ST'));

        //             $matter = DB::table('matterails')->where('receive_id', $value->rvcode)->update(array('branch_receive'=>auth()->user()->branchname->id,'usr_receive'=>auth()->user()->id,'status' => 'ST'));
                       
        //         }
        // }
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
