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
use App\Models\Transaction\TbLog;
use DB;

class ViewReceiveStockComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search, $code, $code_bill, $traffic_id, $trf_code;

    public function render()
    {
        $shipout = '';
        if(!empty($this->code)){
            $this->trf_code = $this->code;
            $traffic = CreateTraffic::where('trf_code', $this->trf_code)->first();
            if(!empty($traffic)){
                $this->traffic_id = $traffic->id;
                    $shipout = LogisticDetail::orderBy('id','desc')->where('branch_id', '!=', auth()->user()->branchname->id)
                    ->where('trf_code',$traffic->id)->whereIn('status',['S','STS'])->where('del',1)->paginate(10);
            }
            // else{
            //     $this->emit('alert', ['type' => 'error', 'message' => 'ຂໍ້ມູນນີ້ບໍ່ມີໃນລະບົບ!']);
            // }
        }
        // else{
        //     $this->emit('alert', ['type' => 'warning', 'message' => 'ກະລຸນາ ປ້ອນຂໍ້ມູນ!']);
        // }
        if(!empty($this->code_bill)){
            $check_shipout = LogisticDetail::where('rvcode',$this->code_bill)->whereIn('status',['ST','STS'])
                            ->where('branch_id',auth()->user()->branchname->id)->where('del',1)->first();
            if(empty($check_shipout)){
                $shipouts = LogisticDetail::where('rvcode',$this->code_bill)->where('status','S')->where('del',1)->first();
                if(!empty($shipouts)){
                $logistic = Logistic::where('id',$shipouts->lgt_id)->where('status','S')->get();
                    foreach($logistic as $item)
                    {
                        $logistic = new Logistic();
                        $logistic->code = $item->code;
                        $logistic->trf_code = $item->trf_code;
                        $logistic->create_date = date('Y-m-d h:i:s');
                        $logistic->user_create = auth()->user()->id;
                        $logistic->branch_id = auth()->user()->branchname->id;
                        $logistic->status = 'ST';
                        $logistic->del = 1;
                        $logistic->created_at = \Carbon\Carbon::now();
                        $logistic->updated_at = \Carbon\Carbon::now();
                        $logistic->save();

                        $logistic_detail = LogisticDetail::where('rvcode',$this->code_bill)->where('status','S')->first();
                        $logis_detail = new LogisticDetail;
                        $logis_detail->lgt_id = $logistic->id;
                        $logis_detail->trf_code = $logistic_detail->trf_code;
                        $logis_detail->rvcode = $logistic_detail->rvcode;
                        $logis_detail->sender_unit = $logistic_detail->sender_unit;
                        $logis_detail->user_unit = $logistic_detail->user_unit;
                        $logis_detail->add_date = $logistic_detail->add_date;
                        $logis_detail->sendto_unit = $logistic_detail->sendto_unit;
                        $logis_detail->status = 'ST';
                        $logis_detail->del = 1;
                        $logis_detail->branch_id = auth()->user()->branchname->id;
                        $logis_detail->created_at = \Carbon\Carbon::now();
                        $logis_detail->updated_at = \Carbon\Carbon::now();
                        $logis_detail->save();

                        $logistic_detail_list = LogisticDetailList::where('detail_id',$shipouts->id)->where('status','S')->get();
                        foreach($logistic_detail_list as $item)
                        {
                            $list = array(
                                'lgt_id'=>$logistic->id,
                                'trf_code'=>$item->trf_code,
                                'detail_id'=>$logis_detail->id,
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
                    }

                    $check = LogisticDetailList::where('rvcode',$shipouts->rvcode)->where('status','S')
                    ->where('status', 1)->first();
                    if(empty($check)){
                        $ship = DB::table('logistics')->where('id', $shipouts->lgt_id)->where('status','S')->update(array('del' =>0));
                    }
                    $shipDetail = DB::table('logistic_details')->where('rvcode',$this->code_bill)->where('status','S')->update(array('del' =>0,'user_receive'=>auth()->user()->id,'receive_date'=>date('Y-m-d h:i:s')));
                    $shipDetailList = DB::table('logistic_detail_lists')->where('rvcode',$this->code_bill)->where('status','S')->update(array('del' =>0));

                    $logistic_code = LogisticDetail::where('rvcode',$this->code_bill)->first();
                    $receive = DB::table('receive_transactions')->where('code', $logistic_code->rvcode)->update(array('status' => 'ST'));
                    $matter = DB::table('matterails')->where('receive_id', $logistic_code->rvcode)->update(array('branch_receive'=>auth()->user()->branchname->id,'usr_receive'=>auth()->user()->id,'status' => 'ST'));

                    $this-> rec_log('STR',$this->code,Auth()->user()->branchname->id,auth()->user()->id,"ພັດສະດຸຮອດ ສູນຄັດແຍກແລ້ວ","N");
                    $this->emit('alert', ['type' => 'success', 'message' => 'ຍອມຮັບສຳເລັດ!']);

                    $this->code_bill = '';
                    $this->trf_code = '';
                    $this->trf_code = $this->code;
                }
            }else{
                $this->emit('alert', ['type' => 'danger', 'message' => 'ທ່ານໄດ້ເພີ່ມລາຍການນີ້ແລ້ວ!']);
            }
        }
        return view('livewire.admin.receive-stock.view-receive-stock-component',compact('shipout'))->layout('layouts.base');
    }

    public function accept($ids)
    {
        // dd($ids);
        $logistic = LogisticDetail::find($ids);
        $logistic_s = Logistic::where('id',$logistic->lgt_id)->first();
                        $logistics = new Logistic();
                        $logistics->code = $logistic_s->code;
                        $logistics->trf_code = $logistic->trf_code;
                        $logistics->create_date = date('Y-m-d h:i:s');
                        $logistics->user_create = auth()->user()->id;
                        $logistics->branch_id = auth()->user()->branchname->id;
                        $logistics->status = 'ST';
                        $logistics->del = 1;
                        $logistics->created_at = \Carbon\Carbon::now();
                        $logistics->updated_at = \Carbon\Carbon::now();
                        $logistics->save();

        $logistic_detail = LogisticDetail::where('id',$ids)->where('status','S')->first();
                        $logis_detail = new LogisticDetail;
                        $logis_detail->lgt_id = $logistics->id;
                        $logis_detail->trf_code = $logistic_detail->trf_code;
                        $logis_detail->rvcode = $logistic_detail->rvcode;
                        $logis_detail->sender_unit = $logistic_detail->sender_unit;
                        $logis_detail->user_unit = $logistic_detail->user_unit;
                        $logis_detail->add_date = $logistic_detail->add_date;
                        $logis_detail->sendto_unit = $logistic_detail->sendto_unit;
                        $logis_detail->status = 'ST';
                        $logis_detail->del = 1;
                        $logis_detail->user_receive = auth()->user()->id;
                        $logis_detail->receive_date = date('Y-m-d');
                        $logis_detail->branch_id = auth()->user()->branchname->id;
                        $logis_detail->created_at = \Carbon\Carbon::now();
                        $logis_detail->updated_at = \Carbon\Carbon::now();
                        $logis_detail->save();

            
            $logistic_detail_list = LogisticDetailList::where('detail_id',$ids)->get();
            foreach($logistic_detail_list as $item)
            {
                $list = array(
                    'lgt_id'=>$logistics->id,
                    'trf_code'=>$item->trf_code,
                    'detail_id'=>$logis_detail->id,
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

        $ship = DB::table('logistics')->where('id', $logistic->lgt_id)->where('status','S')->update(array('del' =>0));
        $shipDetail = DB::table('logistic_details')->where('id', $ids)->where('status','S')->update(array('del' =>0,'user_receive'=>auth()->user()->id,'receive_date'=>date('Y-m-d h:i:s')));
        $shipDetailList = DB::table('logistic_detail_lists')->where('detail_id',  $ids)->where('status','S')->update(array('del' =>0));

        $logistic_code = LogisticDetail::where('id',$ids)->first();
        $receive = DB::table('receive_transactions')->where('code', $logistic_code->rvcode)->update(array('status' => 'ST'));
        $matter = DB::table('matterails')->where('receive_id', $logistic_code->rvcode)->update(array('branch_receive'=>auth()->user()->branchname->id,'usr_receive'=>auth()->user()->id,'status' => 'ST'));

        // $shipout = LogisticDetail::where('lgt_id',$ids)->get();
        // // dd($shipout);
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

        $this-> rec_log('STR',$this->code,Auth()->user()->branchname->id,auth()->user()->id,"ພັດສະດຸຮອດ ສູນຄັດແຍກແລ້ວ","N");
        
        $this->emit('alert', ['type' => 'success', 'message' => 'ຍອມຮັບສຳເລັດ!']);
    }

    public function acceptall()
    {
        $traffic = CreateTraffic::where('trf_code', $this->code)->first();
        if(!empty($traffic)){
            if(auth()->user()->rolename->name == 'stock'){
                $shipout = LogisticDetail::where('trf_code', $traffic->id)->where('status','STS')->get();
                // dd($shipout);
                foreach ($shipout as $item) {
                    $ship = Logistic::find($item->lgt_id);
                    $ship->status = 'ST';
                    $ship->save();
                    $shipDetail = DB::table('logistic_details')->where('id', $item->id)->update(array('status' => 'ST','user_receive'=>auth()->user()->id,'receive_date'=>date('Y-m-d h:i:s')));
                    $shipDetailList = DB::table('logistic_detail_lists')->where('detail_id',  $item->id)->update(array('status' => 'ST'));
                    $details = LogisticDetail::select('id','lgt_id','rvcode','status')->where('id',  $item->id)->where('status', 'ST')->get();
                        foreach ($details as $value) {
                            $receive = DB::table('receive_transactions')->where('code', $value->rvcode)->update(array('status' => 'ST'));
                            $matter = DB::table('matterails')->where('receive_id', $value->rvcode)->update(array('branch_receive'=>auth()->user()->branchname->id,'usr_receive'=>auth()->user()->id,'status' => 'ST'));
                        }
                }
                $this-> rec_log('STR',$this->code,Auth()->user()->branchname->id,auth()->user()->id,"ພັດສະດຸຮອດ ສູນຄັດແຍກແລ້ວ","N");
                $this->emit('alert', ['type' => 'success', 'message' => 'ຍອມຮັບສຳເລັດ!']);
            }else{
                $shipout = LogisticDetail::where('trf_code', $traffic->id)->where('status','S')->get();
                // dd($shipout);
                foreach ($shipout as $item) {
                    $ship = Logistic::find($item->lgt_id);
                    $ship->status = 'ST';
                    $ship->save();
                    $shipDetail = DB::table('logistic_details')->where('id', $item->id)->update(array('status' => 'ST','user_receive'=>auth()->user()->id,'receive_date'=>date('Y-m-d h:i:s')));
                    $shipDetailList = DB::table('logistic_detail_lists')->where('detail_id',  $item->id)->update(array('status' => 'ST'));
                    $details = LogisticDetail::select('id','lgt_id','rvcode','status')->where('id',  $item->id)->where('status', 'ST')->get();
                        foreach ($details as $value) {
                            $receive = DB::table('receive_transactions')->where('code', $value->rvcode)->update(array('status' => 'ST'));
                            $matter = DB::table('matterails')->where('receive_id', $value->rvcode)->update(array('branch_receive'=>auth()->user()->branchname->id,'usr_receive'=>auth()->user()->id,'status' => 'ST'));
                        }
                }
                $this-> rec_log('STR',$this->code,Auth()->user()->branchname->id,auth()->user()->id,"ພັດສະດຸຮອດ ສູນຄັດແຍກແລ້ວ","N");
                $this->emit('alert', ['type' => 'success', 'message' => 'ຍອມຮັບສຳເລັດ!']);
            }
        }
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

    public function rec_log($cd,$vcd,$brid,$usrid,$dts,$sts)
    {
        $addlog= new TbLog();
        $addlog->code=$cd;
        $addlog->valuedt=date('Y-m-d');
        $addlog->vcode=$vcd;
        $addlog->branch_id=$brid;
        $addlog->user_create=$usrid;
        $addlog->details=$dts;
        $addlog->status=$sts;
        $addlog->save();
    }
}
