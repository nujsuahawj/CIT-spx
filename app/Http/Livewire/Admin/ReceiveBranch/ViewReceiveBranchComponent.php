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
use App\Models\Transaction\TbLog;
use DB;

class ViewReceiveBranchComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $code, $search, $traffic_id, $code_bill;

    public function render()
    {
        $shipout = LogisticDetail::where('sendto_unit', auth()->user()->branchname->id)
        ->where('status','F')->where('receive_date', 'like', '%' .date('Y-m-d'). '%')->paginate(10);
        if(!empty($this->code)){
            $traffic = CreateTraffic::where('trf_code', $this->code)->where('status','S')->first();
            if(!empty($traffic)){
                $this->traffic_id = $traffic->id;
                // $logis = Logistic::orderBy('id','desc')->where('branch_id', '!=', auth()->user()->branchname->id)
                // ->where('trf_code',$traffic->id)->first();
                // if(!empty($logis)){
                    // dd($this->traffic_id);
                    $shipout = LogisticDetail::where('sendto_unit', auth()->user()->branchname->id)
                    ->where('status','STS')->where('trf_code', $traffic->id)->where('del',1)->paginate(10);
                // }else{
                //     $this->emit('alert', ['type' => 'error', 'message' => 'ຂໍ້ມູນນີ້ບໍ່ມີໃນລະບົບ!']);
                // }
            }
            // else{
            //     $this->emit('alert', ['type' => 'error', 'message' => 'ຂໍ້ມູນນີ້ບໍ່ມີໃນລະບົບ!']);
            // }
        }
        //  $shipout = LogisticDetail::where('sendto_unit', auth()->user()->branchname->id)
        //             ->where('status','S')->where('rvcode',$this->code)->get();
        if(!empty($this->code_bill)){
            $check_shipout = LogisticDetail::where('rvcode',$this->code_bill)->whereIn('status','F')
                            ->where('branch_id',auth()->user()->branchname->id)->where('del',1)->first();
            if(empty($check_shipout)){
                $shipouts = LogisticDetail::where('rvcode',$this->code_bill)->where('status','STS')->where('del',1)->first();
                if(!empty($shipouts)){
                $logistic = Logistic::where('id',$shipouts->lgt_id)->where('status','STS')->get();
                    foreach($logistic as $item)
                    {
                        $logistic = new Logistic();
                        $logistic->code = $item->code;
                        $logistic->trf_code = $item->trf_code;
                        $logistic->create_date = date('Y-m-d h:i:s');
                        $logistic->user_create = auth()->user()->id;
                        $logistic->branch_id = auth()->user()->branchname->id;
                        $logistic->status = 'F';
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
                        $logis_detail->status = 'F';
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
                                'status'=>'F',
                                'del'=>1,
                                'created_at'=> \Carbon\Carbon::now(),
                                'updated_at'=> \Carbon\Carbon::now()
                            ); 
                            $logistic_detail_list = LogisticDetailList::insert($list);
                        }
                    }

                    $check = LogisticDetailList::where('rvcode',$shipouts->rvcode)->where('status','STS')
                    ->where('status', 1)->first();
                    if(empty($check)){
                        $ship = DB::table('logistics')->where('id', $shipouts->lgt_id)->where('status','STS')->update(array('del' =>0));
                    }
                    $shipDetail = DB::table('logistic_details')->where('rvcode',$this->code_bill)->where('status','STS')->update(array('del' =>0,'user_receive'=>auth()->user()->id,'receive_date'=>date('Y-m-d h:i:s')));
                    $shipDetailList = DB::table('logistic_detail_lists')->where('rvcode',$this->code_bill)->where('status','STS')->update(array('del' =>0));

                    $logistic_code = LogisticDetail::where('rvcode',$this->code_bill)->first();
                    $receive = DB::table('receive_transactions')->where('code', $logistic_code->rvcode)->update(array('status' => 'F'));
                    $matter = DB::table('matterails')->where('receive_id', $logistic_code->rvcode)->update(array('branch_receive'=>auth()->user()->branchname->id,'usr_receive'=>auth()->user()->id,'status' => 'F'));

                    $this->emit('alert', ['type' => 'success', 'message' => 'ຍອມຮັບສຳເລັດ!']);

                    $this-> rec_log('BRR',$logistic->rvcode,Auth()->user()->branchname->id,auth()->user()->id,"ພັດສະດຸ ຮອດໜ່ວຍບໍລິການປາຍທາງແລ້ວ","F");

                    $this->code_bill = '';
                    $this->trf_code = '';
                    $this->trf_code = $this->code;
                }
            }else{
                $this->emit('alert', ['type' => 'danger', 'message' => 'ທ່ານໄດ້ເພີ່ມລາຍການນີ້ແລ້ວ!']);
            }
        }
        return view('livewire.admin.receive-branch.view-receive-branch-component',compact('shipout'))->layout('layouts.base');
    }

    public function accept($ids)
    {   
        $logistic = LogisticDetail::find($ids);
        $logistic_s = Logistic::where('id',$logistic->lgt_id)->first();
                        $logistics = new Logistic();
                        $logistics->code = $logistic_s->code;
                        $logistics->trf_code = $logistic->trf_code;
                        $logistics->create_date = date('Y-m-d h:i:s');
                        $logistics->user_create = auth()->user()->id;
                        $logistics->branch_id = auth()->user()->branchname->id;
                        $logistics->status = 'F';
                        $logistics->del = 1;
                        $logistics->created_at = \Carbon\Carbon::now();
                        $logistics->updated_at = \Carbon\Carbon::now();
                        $logistics->save();

        $logistic_detail = LogisticDetail::where('id',$ids)->where('status','STS')->first();
                        $logis_detail = new LogisticDetail;
                        $logis_detail->lgt_id = $logistics->id;
                        $logis_detail->trf_code = $logistic_detail->trf_code;
                        $logis_detail->rvcode = $logistic_detail->rvcode;
                        $logis_detail->sender_unit = $logistic_detail->sender_unit;
                        $logis_detail->user_unit = $logistic_detail->user_unit;
                        $logis_detail->add_date = $logistic_detail->add_date;
                        $logis_detail->sendto_unit = $logistic_detail->sendto_unit;
                        $logis_detail->status = 'F';
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
                    'status'=>'F',
                    'del'=>1,
                    'created_at'=> \Carbon\Carbon::now(),
                    'updated_at'=> \Carbon\Carbon::now()
                ); 
                $logistic_detail_list = LogisticDetailList::insert($list);
            }

        $ship = DB::table('logistics')->where('id', $logistic->lgt_id)->where('status','STS')->update(array('del' =>0));
        $shipDetail = DB::table('logistic_details')->where('id', $ids)->where('status','STS')->update(array('del' =>0,'user_receive'=>auth()->user()->id,'receive_date'=>date('Y-m-d h:i:s')));
        $shipDetailList = DB::table('logistic_detail_lists')->where('detail_id',  $ids)->where('status','STS')->update(array('del' =>0));

        $logistic_code = LogisticDetail::where('id',$ids)->first();
        $receive = DB::table('receive_transactions')->where('code', $logistic_code->rvcode)->update(array('status' => 'F'));
        $matter = DB::table('matterails')->where('receive_id', $logistic_code->rvcode)->update(array('branch_receive'=>auth()->user()->branchname->id,'usr_receive'=>auth()->user()->id,'status' => 'F'));
        // $shipout = LogisticDetail::find($ids);

        // $out = Logistic::find($shipout->lgt_id);

        // $list = DB::table('logistic_detail_lists')->where('detail_id', $ids)->update(array('status' => 'F'));

        // $shipDetail = DB::table('logistic_details')->where('id', $ids)->update(array('status' => 'F','user_receive'=>auth()->user()->id,'receive_date'=>date('Y-m-d h:i:s')));

        // $details = LogisticDetail::select('id','lgt_id','rvcode','status')->where('id', $ids)->where('status', 'F')->get();
        //     foreach ($details as $key => $value) {

        //         $receive = DB::table('receive_transactions')->where('code', $value->rvcode)->update(array('status' => 'F'));

        //         $matter = DB::table('matterails')->where('receive_id', $value->rvcode)->update(array('status' => 'F'));
        //     }

        $this-> rec_log('BRR',$logistic->rvcode,Auth()->user()->branchname->id,auth()->user()->id,"ພັດສະດຸ ຮອດໜ່ວຍບໍລິການປາຍທາງແລ້ວ","F");
        
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
