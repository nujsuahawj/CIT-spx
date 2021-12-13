<?php

namespace App\Http\Livewire\Admin\ReceiveStock;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Logistic\Logistic;
use App\Models\Logistic\LogisticDetail;
use App\Models\Logistic\LogisticDetailList;
use App\Models\Logistic\LogisticTransection;
use App\Models\Transaction\ReceiveTransaction;
use App\Models\Transaction\Matterail;
use App\Models\Transaction\CreateTraffic;
use App\Models\Transaction\ExpendType;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings\Branch;
use App\Models\Staff\StaffDoing;
use App\Models\Transaction\TbLog;
use Carbon\Carbon;
use DB;

class CreateShipoutStockComponent extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search, $traff_code, $search_detail, $traffic_id, $code, $tranCode, $billReceive, $receiveCode;

    public $hiddenIdTran;

    public function mount()
    {
        $this->code = 'SOST'.date('ymdhis');
    }

    public function render()
    {
        $traff = '';
        $staff = '';

        $add = ReceiveTransaction::where('code', $this->billReceive)->first();
        if(!empty($add))
            {
                $tran = LogisticTransection::where('rvcode', $add->code)->first();
                if(empty($tran)){
                    $logtran = new LogisticTransection;
                    $logtran->rvcode = $add->code;
                    $logtran->sender_unit = Auth()->user()->branchname->id;
                    $logtran->user_unit = Auth()->user()->id;
                    $logtran->add_date = date('Y-m-d h-i-s');
                    $logtran->sendto_unit = $add->branch_receive;
                    $logtran->status = 'P';
                    $logtran->branch_id = Auth()->user()->branchname->id;
                    $logtran->save();

                    $detail = DB::table('logistic_details')->where('rvcode', $add->code)->where('status','ST')
                    ->update(array('del' => 0));
                    $detaillist = DB::table('logistic_detail_lists')->where('rvcode', $add->code)->where('status','ST')
                    ->update(array('del' => 0));

                    $this->emit('alert', ['type' => 'success', 'message' => 'ເພີ່ມ ລາຍການ ສຳເລັດ!']);
                    $this->billReceive = '';
                }else{
                    $this->emit('alert', ['type' => 'error', 'message' => 'ທ່ານໄດ້ເພີ່ມລາຍການນີ້ແລ້ວ!']);
                    $this->billReceive = '';
                }
            }

        $receivetransaction=LogisticDetail::where('branch_id', auth()->user()->branchname->id)
                                        ->where('status','ST')->where('del', 1)->paginate(10);

        if(!empty($this->traffic_id)){
            $traff = CreateTraffic::find($this->traffic_id);
            $staff = StaffDoing::where('trf_code', $traff->trf_code)->get();
        }
        
        $receive = ReceiveTransaction::select('code','valuedt','status')->where('status', 'N')->orderBy('id','desc')->where('branch_create_id', auth()->user()->branchname->id)->get();

        $transaction = LogisticTransection::select('id','rvcode','add_date','sendto_unit')->where('status', 'P')
        ->where(function($query){
            $query->where('rvcode', 'like', '%' .$this->search_detail. '%');
        })->get();

        if(!empty($this->receiveCode))
        {
            $matterail = Matterail::select('matterails.id as id','matterails.code','matterails.large','matterails.height','matterails.longs','matterails.weigh','matterails.currency_code','matterails.branch_id as branch_id',
                'matterails.amount','matterails.paid_type','goods_types.name as gname','product_types.name as pname')
                ->join('goods_types','matterails.goods_id','=','goods_types.id')
                ->join('product_types','matterails.product_type_id','=','product_types.id')
                ->where('matterails.receive_id',  $this->receiveCode)
                ->where('matterails.status',  'ST')->get();
        }else{
            $matterail = Matterail::select('matterails.id as id','matterails.code','matterails.large','matterails.height','matterails.longs','matterails.weigh','matterails.currency_code','matterails.branch_id',
                'matterails.amount','matterails.paid_type','goods_types.name as gname','product_types.name as pname', 'matterails.branch_id as branch_id')
                ->join('goods_types','matterails.goods_id','=','goods_types.id')
                ->join('product_types','matterails.product_type_id','=','product_types.id')
                ->where('matterails.status',  'ST')
                ->get();
        }
        return view('livewire.admin.receive-stock.create-shipout-stock-component',compact('traff', 'staff', 'receive','receivetransaction','transaction','matterail'))->layout('layouts.base');
    }

    public function showbillReceiveDetail()
    {
        $this->dispatchBrowserEvent('show-modal-bill-receive-detail');
    }

    public function addtraff()
    {
        if(!empty($this->traff_code)){
            $traff = CreateTraffic::where('trf_code', $this->traff_code)->first();
            if(!empty($traff))
            {
                $this->traffic_id = $traff->id;
                $this->dispatchBrowserEvent('show-modal-traffic');
            }else{
                $this->emit('alert', ['type' => 'error', 'message' => 'ລາຍການນີ້ບໍ່ມີໃນລະບົບ!']);
                $this->billReceive = '';
            }
        }
    }

    public function addReceive($ids)
    {
        $transaction = LogisticDetail::find($ids);
        if(!empty($transaction))
        {
            $tran = LogisticTransection::where('rvcode', $transaction->rvcode)->first();
            if(empty($tran)){
                $logtran = new LogisticTransection;
                $logtran->rvcode = $transaction->rvcode;
                $logtran->sender_unit = $transaction->sender_unit;
                $logtran->user_unit = $transaction->user_unit;
                $logtran->add_date = date('Y-m-d h-i-s');
                $logtran->sendto_unit = $transaction->sendto_unit;
                $logtran->status = 'P';
                $logtran->branch_id = auth()->user()->branchname->id;
                $logtran->save();

                $detail = DB::table('logistic_details')->where('rvcode', $transaction->rvcode)->where('status','ST')->update(array('del' => 0));
                $detaillist = DB::table('logistic_detail_lists')->where('rvcode', $transaction->rvcode)->where('status','ST')->update(array('del' => 0));
                $this->emit('alert', ['type' => 'success', 'message' => 'ເພີ່ມ ລາຍການ ສຳເລັດ!']);
                $this->billReceive = '';
            }else{
                $this->emit('alert', ['type' => 'error', 'message' => 'ທ່ານໄດ້ເພີ່ມລາຍການນີ້ແລ້ວ!']);
                $this->billReceive = '';
            }
        }else{
            $this->emit('alert', ['type' => 'error', 'message' => 'ລາຍການນີ້ບໍ່ມີໃນລະບົບ!']);
            $this->billReceive = '';
        }
    }

    public function addall()
    {
        $transaction = LogisticDetail::where('branch_id', auth()->user()->branchname->id)
        ->where('status','ST')->where('del',1)->get();

            foreach($transaction as $item){
            $logtran = new LogisticTransection;
            $logtran->rvcode = $item->rvcode;
            $logtran->sender_unit = auth()->user()->branchname->id;
            $logtran->user_unit = auth()->user()->id;
            $logtran->add_date = date('Y-m-d H-i-s');
            $logtran->sendto_unit = $item->sendto_unit;
            $logtran->status = 'P';
            $logtran->branch_id = auth()->user()->branchname->id;
            $logtran->save();

            $detail = DB::table('logistic_details')->where('rvcode', $item->rvcode)->where('status','ST')
                    ->update(array('del' => 0));
            $detaillist = DB::table('logistic_detail_lists')->where('rvcode', $item->rvcode)->where('status','ST')
                    ->update(array('del' => 0));
            }
            $this->emit('alert', ['type' => 'success', 'message' => 'ເພີ່ມ ລາຍການ ສຳເລັດ!']);
    }

    public function showDestroyTran($ids)
    {
        $this->dispatchBrowserEvent('show-modal-delete');
        $singleData = LogisticTransection::find($ids);
        $this->hiddenIdTran = $ids;
        $this->tranCode = $singleData->rvcode;
    }

    public function destroyTran($ids)
    {
        $this->dispatchBrowserEvent('hide-modal-delete');
        $singleData = LogisticTransection::find($ids);
        $detail = DB::table('logistic_details')->where('rvcode', $singleData->rvcode)->update(array('status'=>'ST','del' => 1));
        $singleData->delete();
        $this->emit('alert', ['type' => 'success', 'message' => 'ລົບລາຍການສຳເລັດ!']);
    }

    public function save()
    {
        $transaction = LogisticTransection::select('id','rvcode','add_date','sendto_unit')->where('status', 'P')->where('branch_id', auth()->user()->branchname->id)->first();
        
            $this->validate([
                'traffic_id'=>'required'
            ],[
                'traffic_id.required'=>'ກຸລະນາເລືອກ ຄິວຂົນສົ່ງ ກ່ອນ!',
            ]);
        
        if(!empty($transaction)){
            $logistic = new Logistic();
            $logistic->code = $this->code;
            $logistic->trf_code = $this->traffic_id;
            $logistic->create_date = date('Y-m-d h:i:s');
            $logistic->user_create = auth()->user()->id;
            $logistic->branch_id = auth()->user()->branchname->id;
            $logistic->status = 'STS';
            $logistic->del = 1;
            $logistic->save();

            $traffic = CreateTraffic::where('trf_code', $this->traff_code)->first();
            $traffic->status = 'S';
            $traffic->save();

            $trans = LogisticTransection::select('id','rvcode','sender_unit','user_unit','add_date','sendto_unit','status','branch_id')->where('status', 'P')->where('branch_id', auth()->user()->branchname->id)->get();
            
            foreach ($trans as $key => $value) {
                $list = array(
                    'lgt_id'=>$logistic->id,
                    'trf_code'=>$logistic->trf_code,
                    'rvcode'=>$value->rvcode,
                    'sender_unit'=>$value->sender_unit,
                    'user_unit'=>$value->user_unit,
                    'add_date'=>$value->add_date,
                    'sendto_unit'=>$value->sendto_unit,
                    'status'=>'STS',
                    'del'=>1,
                    'branch_id'=>$value->branch_id,
                    'created_at'=> \Carbon\Carbon::now(),
                    'updated_at'=> \Carbon\Carbon::now()
                ); 
                
                $logisticDetail = LogisticDetail::insert($list);

                    $detail = LogisticDetail::where('rvcode', $value->rvcode)->first();

                    $materails = Matterail::where('receive_id', $value->rvcode)->get();

                    foreach ($materails as $key => $value2) {
                    $list_mat = array(
                        'lgt_id'=>$logistic->id,
                        'detail_id'=>$detail->id,
                        'rvcode'=>$detail->rvcode,
                        'code'=>$value2->code,
                        'good_id'=>$value2->goods_id,
                        'product_type_id'=>$value2->product_type_id,
                        'large'=>$value2->large,
                        'height'=>$value2->height,
                        'longs'=>$value2->longs,
                        'weigh'=>$value2->weigh,
                        'amount'=>$value2->amount,
                        'paid_type'=>$value2->paid_type,
                        'sendto_unit'=>$detail->sendto_unit,
                        'user_id'=>Auth()->user()->id,
                        'branch_id'=>Auth()->user()->branchname->id,
                        'status'=>'STS',
                        'del'=>1,
                        'created_at'=> \Carbon\Carbon::now(),
                        'updated_at'=> \Carbon\Carbon::now()
                    ); 
                    $logisticDetailList = LogisticDetailList::insert($list_mat);
                    }

                $receive = DB::table('receive_transactions')->where('code', $value->rvcode)->update(array('status' => 'STS'));

                $matter = DB::table('matterails')->where('receive_id', $value->rvcode)->update(array('status' => 'STS'));

                $deleteTrans = LogisticTransection::where('id', $value->id)->delete();

                $this-> rec_log('STS',$value->rvcode,Auth()->user()->branchname->id,auth()->user()->id,"ກຳລັງຂົນສົ່ງ ພັດສະດຸ","STS");
            }

            return redirect(route('admin.shipout_stock'));
        }else{
            $this->emit('alert', ['type' => 'warning', 'message' => 'ກະລຸນາເພີ່ມລາຍການ ບິນຮັບຝາກເຄື່ອງ ກ່ອນ!']);
        }
    }

    public function showDetailReceive($ids)
    {
        $this->dispatchBrowserEvent('show-modal-receive-detail');
        $trans = LogisticTransection::find($ids);
        $this->receiveCode = $trans->rvcode;
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
