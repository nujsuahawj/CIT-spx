<?php

namespace App\Http\Livewire\Admin\Shipout;

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

class EditShipoutComponent extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search, $traff_code, $search_detail, $traffic_id, $code, $tranCode, $billReceive, $receiveCode;

    public $hiddenIdTran, $hiddenId;

    public function mount($id)
    {
        $logistic = Logistic::find($id);
        $traffic = CreateTraffic::where('trf_code', $logistic->trf_code)->first();
        $this->hiddenId = $id;
        $this->code = $logistic->code;
        $this->traffic_id = $logistic->trf_code;
    }

    public function render()
    {
        $traff = '';
        $staff = '';
        if(!empty($this->traffic_id)){
            $traff = CreateTraffic::find($this->traffic_id);
            $staff = StaffDoing::where('trf_code', $traff->trf_code)->get();
        }
        $receive = ReceiveTransaction::select('code','valuedt','status')->where('status', 'N')->orderBy('id','desc')->where('branch_create_id', auth()->user()->branchname->id)->get();

        $transaction = LogisticDetail::select('id','lgt_id','rvcode','add_date','sendto_unit')->where('lgt_id', $this->hiddenId)->where('branch_id', auth()->user()->branchname->id)
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
        })->where('status', 'N')->paginate(10);

        if(!empty($this->receiveCode))
        {
            $matterail = Matterail::select('matterails.id as id','matterails.code','matterails.large','matterails.height','matterails.longs','matterails.weigh','matterails.currency_code','matterails.branch_id as branch_id',
                'matterails.amount','matterails.paid_type','goods_types.name as gname','product_types.name as pname','calculate_types.name as calname')
                ->join('goods_types','matterails.goods_id','=','goods_types.id')
                ->join('product_types','matterails.product_type_id','=','product_types.id')
                ->join('calculate_prices','matterails.cal_price_id','=','calculate_prices.id')
                ->join('calculate_types','calculate_prices.cal_type_id','=','calculate_types.id')
                ->where('receive_id',  $this->receiveCode)->get();
        }else{
            $matterail = Matterail::select('matterails.id as id','matterails.code','matterails.large','matterails.height','matterails.longs','matterails.weigh','matterails.currency_code','matterails.branch_id',
                'matterails.amount','matterails.paid_type','goods_types.name as gname','product_types.name as pname','calculate_types.name as calname')
                ->join('goods_types','matterails.goods_id','=','goods_types.id')
                ->join('product_types','matterails.product_type_id','=','product_types.id')
                ->join('calculate_prices','matterails.cal_price_id','=','calculate_prices.id')
                ->join('calculate_types','calculate_prices.cal_type_id','=','calculate_types.id')
                ->where('matterails.branch_id',  auth()->user()->branchname->id)->get();
        }

        return view('livewire.admin.shipout.edit-shipout-component',compact('traff','staff','receive','receivetransaction','transaction','matterail'))->layout('layouts.base');
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
                $tran = LogisticDetail::where('rvcode', $transaction->code)->first();
                if(empty($tran)){
                    $logtran = new LogisticDetail;
                    $logtran->lgt_id = $this->hiddenId;
                    $logtran->rvcode = $transaction->code;
                    $logtran->sender_unit = $transaction->branch_send;
                    $logtran->user_unit = Auth()->user()->id;
                    $logtran->add_date = date('Y-m-d h-i-s');
                    $logtran->sendto_unit = $transaction->branch_receive;
                    $logtran->status = 'S';
                    $logtran->branch_id = Auth()->user()->branchname->id;
                    $logtran->save();

            $receive = DB::table('receive_transactions')->where('code', $logtran->rvcode)->update(array('status' => 'S'));

            $matter = DB::table('matterails')->where('receive_id', $logtran->rvcode)->update(array('status' => 'S'));

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

    public function addbillReceive()
    {
        if(!empty($this->billReceive)){
            $transactions = ReceiveTransaction::where('code', $this->billReceive)->first();
            if(!empty($transactions))
            {
                $tran = LogisticTransection::where('rvcode', $transactions->code)->first();
                if(empty($tran)){
                    $logtran = new LogisticTransection;
                    $logtran->rvcode = $transactions->code;
                    $logtran->sender_unit = $transactions->branch_send;
                    $logtran->user_unit = Auth()->user()->id;
                    $logtran->add_date = date('Y-m-d');
                    $logtran->sendto_unit = $transactions->branch_receive;
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
    }

    public function showDestroyTran($ids)
    {
        $this->dispatchBrowserEvent('show-modal-delete');
        $singleData = LogisticDetail::find($ids);
        $this->hiddenIdTran = $ids;
        $this->tranCode = $singleData->rvcode;
    }

    public function destroyTran($ids)
    {
        $this->dispatchBrowserEvent('hide-modal-delete');
        $singleData = LogisticDetail::find($ids);
        $singleData->delete();
        $this->emit('alert', ['type' => 'success', 'message' => 'ລົບລາຍການສຳເລັດ!']);
    }

    public function save()
    {
        $transaction = LogisticDetail::select('id','rvcode','add_date','sendto_unit')->where('lgt_id', $this->hiddenId)->where('branch_id', auth()->user()->branchname->id)->first();
        
            $this->validate([
                'traffic_id'=>'required'
            ],[
                'traffic_id.required'=>'ກຸລະນາເລືອກ ຄິວຂົນສົ່ງ ກ່ອນ!',
            ]);
        // dd($transaction->id)
        if(!empty($transaction)){
            $logistic = Logistic::find($this->hiddenId);
            $logistic->trf_code = $this->traffic_id;
            $logistic->create_date = date('Y-m-d h:i:s');
            $logistic->user_create = auth()->user()->id;
            $logistic->branch_id = auth()->user()->branchname->id;
            $logistic->save();

            $traffic = CreateTraffic::where('trf_code', $this->traff_code)->first();
            $traffic->stop_date = date('Y-m-d h:i:s');
            $traffic->status = 'S';
            $traffic->save();

            return redirect(route('admin.shipout'));
        }else{
            $this->emit('alert', ['type' => 'warning', 'message' => 'ກະລຸນາເພີ່ມລາຍການ ບິນຮັບຝາກເຄື່ອງ ກ່ອນ!']);
        }
    }

    public function showDetailReceive($ids)
    {
        $this->dispatchBrowserEvent('show-modal-receive-detail');
        $trans = LogisticDetail::find($ids);
        $this->receiveCode = $trans->rvcode;
    }

}
