<?php

namespace App\Http\Livewire\Admin\ReceiveStock;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Logistic\Logistic;
use App\Models\Logistic\LogisticDetail;
use App\Models\Logistic\LogisticTransection;
use App\Models\Transaction\ReceiveTransaction;
use App\Models\Transaction\Matterail;
use App\Models\Transaction\CreateTraffic;
use App\Models\Transaction\ExpendType;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings\Branch;
use App\Models\Staff\StaffDoing;
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
        // if(!empty($this->traffic_id)){
        //     $traff = CreateTraffic::find($this->traffic_id);
        //     $staff = StaffDoing::where('trf_code', $traff->trf_code)->get();
        // }
        
        // $receive = ReceiveTransaction::select('code','valuedt','status')->where('status', 'N')->orderBy('id','desc')->where('branch_create_id', auth()->user()->branchname->id)->get();

        // $transaction = LogisticTransection::select('id','rvcode','add_date','sendto_unit')->where('status', 'P')->where('branch_id', auth()->user()->branchname->id)
        // ->where(function($query){
        //     $query->where('rvcode', 'like', '%' .$this->search_detail. '%');
        // })->get();

        // $receivetransaction=ReceiveTransaction::select('receive_transactions.*','bs.company_name_la as brs','br.company_name_la as brr','cs.name as css','cr.name as crr') 
        // ->join('branches as bs','receive_transactions.branch_send','=','bs.id')
        // ->join('branches as br','receive_transactions.branch_receive','=','br.id')
        // ->join('customers as cs','receive_transactions.customer_send','=','cs.id')
        // ->join('customers as cr','receive_transactions.customer_receive','=','cr.id')
        // ->where(function($query){
        //     $query->where('receive_transactions.code', 'like', '%' .$this->search. '%');
        // })->where('status', 'ST')->paginate(10);

        // if(!empty($this->receiveCode))
        // {

        //     $matterail = Matterail::select('matterails.id as id','matterails.code','matterails.large','matterails.height','matterails.longs','matterails.weigh','matterails.currency_code','matterails.branch_id as branch_id',
        //         'matterails.amount','matterails.paid_type','goods_types.name as gname','product_types.name as pname','calculate_types.name as calname')
        //         ->join('goods_types','matterails.goods_id','=','goods_types.id')
        //         ->join('product_types','matterails.product_type_id','=','product_types.id')
        //         ->join('calculate_prices','matterails.cal_price_id','=','calculate_prices.id')
        //         ->join('calculate_types','calculate_prices.cal_type_id','=','calculate_types.id')
        //         ->where('matterails.receive_id',  $this->receiveCode)->get();
        //         // dd($matterail);
        // }else{
        //     $matterail = Matterail::select('matterails.id as id','matterails.code','matterails.large','matterails.height','matterails.longs','matterails.weigh','matterails.currency_code','matterails.branch_id',
        //         'matterails.amount','matterails.paid_type','goods_types.name as gname','product_types.name as pname','calculate_types.name as calname')
        //         ->join('goods_types','matterails.goods_id','=','goods_types.id')
        //         ->join('product_types','matterails.product_type_id','=','product_types.id')
        //         ->join('calculate_prices','matterails.cal_price_id','=','calculate_prices.id')
        //         ->join('calculate_types','calculate_prices.cal_type_id','=','calculate_types.id')
        //         ->where('matterails.branch_id',  Auth()->user()->branchname->id)->get();
        // }
        if(!empty($this->traffic_id)){
            $traff = CreateTraffic::find($this->traffic_id);
            $staff = StaffDoing::where('trf_code', $traff->trf_code)->get();
        }
        
        $receive = ReceiveTransaction::select('code','valuedt','status')->where('status', 'N')->orderBy('id','desc')->where('branch_create_id', auth()->user()->branchname->id)->get();

        $transaction = LogisticTransection::select('id','rvcode','add_date','sendto_unit')->where('status', 'P')->where('branch_id', auth()->user()->branchname->id)
        ->where(function($query){
            $query->where('rvcode', 'like', '%' .$this->search_detail. '%');
        })->get();

        $receivetransaction=ReceiveTransaction::select('receive_transactions.*','bs.company_name_la as brs','br.company_name_la as brr','cs.name as css','cr.name as crr') 
        ->join('branches as bs','receive_transactions.branch_send','=','bs.id')
        ->join('branches as br','receive_transactions.branch_receive','=','br.id')
        ->join('customers as cs','receive_transactions.customer_send','=','cs.id')
        ->join('customers as cr','receive_transactions.customer_receive','=','cr.id')
        ->where(function($query){
            $query->where('receive_transactions.code', 'like', '%' .$this->search. '%');
        })->where('status', 'ST')->where('receive_transactions.branch_send', auth()->user()->branchname->id)->paginate(10);

        if(!empty($this->receiveCode))
        {

            $matterail = Matterail::select('matterails.id as id','matterails.code','matterails.large','matterails.height','matterails.longs','matterails.weigh','matterails.currency_code','matterails.branch_id as branch_id',
                'matterails.amount','matterails.paid_type','goods_types.name as gname','product_types.name as pname','calculate_types.name as calname')
                ->join('goods_types','matterails.goods_id','=','goods_types.id')
                ->join('product_types','matterails.product_type_id','=','product_types.id')
                ->join('calculate_prices','matterails.cal_price_id','=','calculate_prices.id')
                ->join('calculate_types','calculate_prices.cal_type_id','=','calculate_types.id')
                ->where('matterails.receive_id',  $this->receiveCode)->where('matterails.branch_id',  Auth::user()->branchname->id)->get();
                // dd($matterail);
        }else{
            $matterail = Matterail::select('matterails.id as id','matterails.code','matterails.large','matterails.height','matterails.longs','matterails.weigh','matterails.currency_code','matterails.branch_id',
                'matterails.amount','matterails.paid_type','goods_types.name as gname','product_types.name as pname','calculate_types.name as calname', 'matterails.branch_id as branch_id')
                ->join('goods_types','matterails.goods_id','=','goods_types.id')
                ->join('product_types','matterails.product_type_id','=','product_types.id')
                ->join('calculate_prices','matterails.cal_price_id','=','calculate_prices.id')
                ->join('calculate_types','calculate_prices.cal_type_id','=','calculate_types.id')
                ->where('matterails.branch_id',  Auth::user()->branchname->id)->get();
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
                // dd('ss');
                // $this->dispatchBrowserEvent('show-modal-delete');
                $this->dispatchBrowserEvent('show-modal-traffic');
            }else{
                $this->emit('alert', ['type' => 'error', 'message' => 'ລາຍການນີ້ບໍ່ມີໃນລະບົບ!']);
                $this->billReceive = '';
            }
        }
    }

    public function addReceive($ids)
    {
            $transaction = ReceiveTransaction::find($ids);
            if(!empty($transaction))
            {
                $tran = LogisticTransection::where('rvcode', $transaction->code)->first();
                if(empty($tran)){
                    $logtran = new LogisticTransection;
                    $logtran->rvcode = $transaction->code;
                    $logtran->sender_unit = Auth()->user()->branchname->id;
                    $logtran->user_unit = Auth()->user()->id;
                    $logtran->add_date = date('Y-m-d h-i-s');
                    $logtran->sendto_unit = $transaction->branch_receive;
                    $logtran->status = 'P';
                    $logtran->branch_id = Auth()->user()->branchname->id;
                    $logtran->save();

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
        $singleData->delete();
        $this->emit('alert', ['type' => 'success', 'message' => 'ລົບລາຍການສຳເລັດ!']);
    }

    public function save()
    {
        // $transaction = LogisticTransection::select('id','rvcode','add_date','sendto_unit')->where('status', 'P')->where('branch_id', auth()->user()->branchname->id)->first();
        
        //     $this->validate([
        //         'traffic_id'=>'required'
        //     ],[
        //         'traffic_id.required'=>'ກຸລະນາເລືອກ ຄິວຂົນສົ່ງ ກ່ອນ!',
        //     ]);
        // // dd($transaction->id)
        // if(!empty($transaction)){
        //     $logistic = new Logistic();
        //     $logistic->code = $this->code;
        //     $logistic->trf_code = $this->traffic_id;
        //     $logistic->create_date = date('Y-m-d h:i:s');
        //     $logistic->user_create = auth()->user()->id;
        //     $logistic->branch_id = auth()->user()->branchname->id;
        //     $logistic->status = 'S';
        //     $logistic->save();

        //     $traffic = CreateTraffic::where('trf_code', $this->traffic_id)->first();
        //     $traffic->stop_date = date('Y-m-d h:i:s');
        //     $traffic->status = 'S';
        //     $traffic->save();

        //     $trans = LogisticTransection::select('id','rvcode','sender_unit','user_unit','add_date','sendto_unit','status','branch_id')->where('status', 'P')->where('branch_id', auth()->user()->branchname->id)->get();
        //     foreach ($trans as $key => $value) {
        //         $list = array(
        //             'lgt_id'=>$logistic->id,
        //             'rvcode'=>$value->rvcode,
        //             'sender_unit'=>$value->sender_unit,
        //             'user_unit'=>$value->user_unit,
        //             'add_date'=>$value->add_date,
        //             'sendto_unit'=>$value->sendto_unit,
        //             'status'=>'S',
        //             'branch_id'=>$value->branch_id,
        //             'created_at'=> \Carbon\Carbon::now(),
        //             'updated_at'=> \Carbon\Carbon::now()
        //         );
                
        //         $logisticDetail = LogisticDetail::insert($list);

        //         $receive = DB::table('receive_transactions')->where('code', $value->rvcode)->update(array('status' => 'S'));

        //         $matter = DB::table('matterails')->where('receive_id', $value->rvcode)->update(array('status' => 'S'));

        //         $deleteTrans = LogisticTransection::where('id', $value->id)->delete();
        //     }

        //     return redirect(route('admin.shipout'));
        // }else{
        //     $this->emit('alert', ['type' => 'warning', 'message' => 'ກະລຸນາເພີ່ມລາຍການ ບິນຮັບຝາກເຄື່ອງ ກ່ອນ!']);
        // }

        $transaction = LogisticTransection::select('id','rvcode','add_date','sendto_unit')->where('status', 'P')->where('branch_id', auth()->user()->branchname->id)->first();
        
            $this->validate([
                'traffic_id'=>'required'
            ],[
                'traffic_id.required'=>'ກຸລະນາເລືອກ ຄິວຂົນສົ່ງ ກ່ອນ!',
            ]);
        // dd($transaction->id)
        if(!empty($transaction)){
            $logistic = new Logistic();
            $logistic->code = $this->code;
            $logistic->trf_code = $this->traffic_id;
            $logistic->create_date = date('Y-m-d h:i:s');
            $logistic->user_create = auth()->user()->id;
            $logistic->branch_id = auth()->user()->branchname->id;
            $logistic->status = 'S';
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
                    'status'=>'S',
                    'branch_id'=>$value->branch_id,
                    'created_at'=> \Carbon\Carbon::now(),
                    'updated_at'=> \Carbon\Carbon::now()
                ); 
                $logisticDetail = LogisticDetail::insert($list);

                    $detail = LogisticDetail::where('rvcode', $value->rvcode)->first();

                    $materails = Matterail::where('receive_id', $value->rvcode)->get();

                    foreach ($materails as $key => $value2) {
                    $list_mat = array(
                        'lgt_id'=>$detail->lgt_id,
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
                        'status'=>'S',
                        'created_at'=> \Carbon\Carbon::now(),
                        'updated_at'=> \Carbon\Carbon::now()
                    ); 
                    $logisticDetailList = LogisticDetailList::insert($list_mat);
                    }

                $receive = DB::table('receive_transactions')->where('code', $value->rvcode)->update(array('status' => 'S'));

                $matter = DB::table('matterails')->where('receive_id', $value->rvcode)->update(array('status' => 'S'));

                $deleteTrans = LogisticTransection::where('id', $value->id)->delete();
            }

            return redirect(route('admin.shipout'));
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
}
