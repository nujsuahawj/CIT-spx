<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction\ReceiveTransaction;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ReceiveResource;
use App\Http\Resources\SearchReceiveResource;
use App\Http\Resources\BillReceiveResource;
use App\Http\Resources\BillallReceiveResource;
use App\Models\Receive;
use App\Models\Condition\Customer;
use App\Models\Settings\CustomerType;
use App\Models\Settings\Branch;
use App\Models\Settings\Province;
use App\Models\Settings\District;
use App\Models\Settings\Village;
use App\Models\Settings\GoodsType;
use App\Models\Settings\CalculatePrice;
use App\Models\Condition\ProductType;
use App\Models\Transaction\Matterail;
use App\Models\Transaction\ListMatterail;
use App\Http\Resources\MatterailResource;
use DB;

class ReceiveApiController extends Controller
{   
   
    // public function indexOrder(){
        
    //     return response()->json([MatterailResource::collection(Matterail::all()->where('usr_create', auth()->user()->id))],200);
    // }
    
    public $search_cus;
    public function indexbill(){
        return response()->json([ReceiveResource::collection(ReceiveTransaction::select('receive_transactions.*','cusen.name','cusen.phone','cusen.pro_id','cusen.dis_id','cusen.vil_id','matterails.goods_id','matterails.product_type_id','matterails.large','matterails.height','matterails.longs','matterails.weigh','matterails.status as ms')
                                ->join('customers as cusen','receive_transactions.customer_receive','=','cusen.id')
                                ->join('matterails','receive_transactions.code','=','matterails.receive_id')
                                ->where('creator_id', auth()->user()->id)->get())],200);
    }

    public function search($name){
        return response()->json([SearchReceiveResource::collection(ReceiveTransaction::select('receive_transactions.*','cr.name as crr','cr.phone as crphone') 
        ->join('customers as cr','receive_transactions.customer_receive','=','cr.id')
            ->where('receive_transactions.code', $name)
            ->orWhere('cr.name', $name)
            ->orWhere('cr.phone', $name)
            ->get())],200);
    }

    public function addOrder (Request $request){

        $request->validate([
            'customer_receive'=>'required',
            'goods_type_id'=>'required',
            'product_type_id'=>'required',
            'large'=>'numeric|min:0',
            'height'=>'numeric|min:0',
            'longs'=>'numeric|min:0',
            'weigh'=>'numeric|min:0'
        ],[
            'goods_type_id.required'=>'ເລືອກປະເພດເຄື່ອງ',
            'product_type_id.required'=>'ເລືອກໝວດໝູ່',
            'large.numeric'=>'ຕື່ມຄ່າ>=0',
            'large.min'=>'ຕື່ມຄ່າ>=0',
            'height.numeric'=>'ຕື່ມຄ່າ>=0',
            'height.min'=>'ຕື່ມຄ່າ>=0',
            'longs.numeric'=>'ຕື່ມຄ່າ>=0',
            'longs.min'=>'ຕື່ມຄ່າ>=0',
            'weigh.numeric'=>'ຕື່ມຄ່າ>=0',
            'weigh.min'=>'ຕື່ມຄ່າ>=0'
        ]);
        $r1='LAK';
        $r2='NML';
        $cus = '1';
        $rv = 'VC'.date('Ymdms');
        $th = 'TH'.date('Ymdms');
        $cu = 'C'.date('Ymdms');
        $customer = new Customer();
        $customer -> code = $cu;
        $customer -> name = $request -> customer_receive;
        $customer -> phone = $request -> phone_receive;
        $customer -> cus_type_id = $cus;
        $customer -> pro_id = $request->pro_id;
        $customer -> dis_id = $request->dis_id;
        $customer -> vil_id = $request->vil_id;
        $customer->save();
        $matterail = new Matterail;
        $matterail -> code = $th;
        $matterail -> receive_id = $rv;
        $matterail -> goods_id = $request->goods_type_id;
        $matterail -> product_type_id = $request->product_type_id;
        $matterail -> large = $request->large;
        $matterail -> height = $request->height;
        $matterail -> longs = $request->longs;
        $matterail -> weigh = $request->weigh;
        $matterail -> status ="P";
        $matterail->save();
        $lis_m = new ListMatterail();
        $lis_m->rvcode = $rv;
        $lis_m->mcode = $th;
        $lis_m -> currency_code = $r1;
        $lis_m->save();
        $receive = new ReceiveTransaction;
        $receive -> code = $rv;
        $receive -> type = 'SND_BILL';
        $receive -> valuedt =  date('Y-m-d', time());
        $receive-> customer_send = $request->customer_send;
        $receive-> customer_receive = $customer->id;
        $receive -> service_type = $r2;
        $receive -> currency_code = $r1;
        $receive -> creator_id = auth()->user()->id;
        $receive -> status = $request->status; 
        $receive -> note = $request->note;       
        $results = $receive->save();
        return response()->json(['message' => "ເພີມຊໍ້ມູນສຳເລັດ"]);
    }

    public function maxIdReceive()
    {
        return response([
            'data'=> ReceiveTransaction::select('id')->count('id')
        ],200);
    }

    public function countIdMaterail($code)
    {
        return response([
            'data'=> Matterail::where('receive_id',$code)->count('id')
        ],200);
    }

    public function postMatterail(Request $request)
    {
        $th = '';
        $max = Matterail::count('id');
        if(!empty($max)){
            $sum = $max+1;
            $th =  'SPXOD-00'.$sum;
        }else{
            $th = 'SPXOD-00'.'1';
        }

        $v_price=0;
        $w_price=0;
        $cal_price=0;
        $in_rate=0.03;

        $v = '';
        $cal_price = '';
        $fun_id = '';

        $fprod=ProductType::where('id',$request->product_type_id)->first();

        if($fprod->func_type=='CP'){
            $v=$request->large + $request->height + $request->longs;
        
                if($v<=280 && $request->weigh<=30){
                   $find_price = CalculatePrice::selectRaw('max(id) as id,max(price) AS price') 
                                ->where('cal_type_id',1)
                                ->where('distance_id',$request->dist_id)
                                ->where('status',1)->where('del',1)
                                ->first();
                  
                        if($find_price->id !=null){
                            $cal_price = $find_price->price;
                            $fun_id= $find_price->id;

                        if ((($request->r2=='COD') || ($request->insur=='TRUE')) && ($request->amount==0)){
                                return response()->json(['message' => "ກະລຸນາເພີ່ມລາຄາຂົນສົ່ງ ໃຫ້ຖືກຕ້ອງ!"]);
                            }else{
                                $th = 'TH'.date('Ymdms');
                                $matterail = new Matterail();
                                $matterail->code = $th;
                                $matterail->receive_id = $request->code;
                                $matterail->goods_id = $request->goods_type_id;
                                $matterail->product_type_id = $request->product_type_id;
                                $matterail->large = $request->large;
                                $matterail->height = $request->height;
                                $matterail->longs = $request->longs;
                                $matterail->weigh = $request->weigh;
                                $matterail->cal_price_id = $fun_id;
                                $matterail->currency_code = 'LAK';
                                $matterail->amount = $cal_price;
                                $matterail->cod_amount = $request->amount;
                                if($request->insur=='TRUE'){
                                    $matterail->insur_amount= $request->amount * $in_rate;
                                }else{
                                    $matterail->insur_amount=0;
                                }   
                                $matterail->pack_id = $request->pack_id;
                                $matterail->pack_amount = $request->pack_amount;    
                                $matterail->paid_type = $request->piadtype;
                                $matterail->paid_by = $request->piadtype;
                                $matterail->branch_id = auth()->user()->branchname->id;
                                $matterail->usr_create = auth()->user()->id;
                                $matterail->status ="P";
                                $matterail->save();
                    
                                // $lis_m = new ListMatterail();
                                // $lis_m->rvcode = $request->code;
                                // $lis_m->mcode = $th;
                                // $lis_m->cal_price_id = $fun_id;
                                // $lis_m->currency_code = $request->r1;
                                // $lis_m->amount = $cal_price;
                                // $lis_m->cod_amount = $request->amount;
                                // if($request->insur=='TRUE'){
                                //     $lis_m->insur_amount= $request->amount * $in_rate;
                                // }else{
                                //     $lis_m->insur_amount=0;
                                // }    
                                // $lis_m->pack_id = $request->pack;
                                // $lis_m->pack_amount = $request->pack_amount;       
                                // $lis_m->paid_type = $request->piadtype;
                                // $lis_m->paid_by = $request->piadtype;
                                // $lis_m->branch_id = auth()->user()->branchname->id;
                                // $lis_m->usr_create = auth()->user()->id;
                                // $lis_m->status ="P";
                                // $lis_m->save();
                            }   
                        } else { 
                            return response()->json(['message' => "ສິນຄ້າບໍ່ຢູ່ໃນເງື່ອນໄຂການຄິດໄລ່ !"]);
                        }

                }elseif($v<=280 && $request->weigh>30){ // ELSE BIG
                    $find_price=CalculatePrice::select('id','price')->where('min_val','<',$request->weigh)->where('max_val','>=',$request->weigh)
                                                ->where('status',1)->where('cal_type_id',2)->where('distance_id',$request->dist_id)->where('del',1)->first();
                    if($find_price->id !=null){
                        $cal_price = $find_price->price * $request->weigh;
                        $fun_id= $find_price->id;
                        if ((($request->r2=='COD') || ($request->insur=='TRUE')) && ($request->amount==0)){
                            return response()->json(['message' => "ກະລຸນາເພີ່ມລາຄາຂົນສົ່ງ ໃຫ້ຖືກຕ້ອງ!"]);
                        }else{
                            $th = 'TH'.date('Ymdms');
                            $matterail = new Matterail();
                            $matterail->code = $th;
                            $matterail->receive_id = $request->code;
                            $matterail->goods_id = $request->goods_type_id;
                            $matterail->product_type_id = $request->product_type_id;
                            $matterail->large = $request->large;
                            $matterail->height = $request->height;
                            $matterail->longs = $request->longs;
                            $matterail->weigh = $request->weigh;
                            $matterail->cal_price_id = $fun_id;
                            $matterail->currency_code = 'LAK';
                            $matterail->amount = $cal_price;
                            $matterail->cod_amount = $request->amount;
                            if($request->insur=='TRUE'){
                                $matterail->insur_amount= $request->amount * $in_rate;
                            }else{
                                $matterail->insur_amount=0;
                            }   
                            $matterail->pack_id = $request->pack;
                            $matterail->pack_amount = $request->pack_amount;    
                            $matterail->paid_type = $request->piadtype;
                            $matterail->paid_by = $request->piadtype;
                            $matterail->branch_id = Auth()->user()->branchname->id;
                            $matterail->usr_create = Auth()->user()->id;
                            $matterail->status ="P";
                            $matterail->save();
                
                            $lis_m = new ListMatterail();
                            $lis_m->rvcode = $request->code;
                            $lis_m->mcode = $th;
                            $lis_m->cal_price_id = $fun_id;
                            $lis_m->currency_code = $request->r1;
                            $lis_m->amount = $cal_price;
                            $lis_m->cod_amount = $request->amount;
                            if($request->insur=='TRUE'){
                                $lis_m->insur_amount= $request->amount * $in_rate;
                            }else{
                                $lis_m->insur_amount=0;
                            }    
                            $lis_m->pack_id = $request->pack;
                            $lis_m->pack_amount = $request->pack_amount;       
                            $lis_m->paid_type = $request->piadtype;
                            $lis_m->paid_by = $request->piadtype;
                            $lis_m->branch_id = auth()->user()->branchname->id;
                            $lis_m->usr_create = auth()->user()->id;
                            $lis_m->status ="P";
                            $lis_m->save();
                        }   
                    } else { 
                        return response()->json(['message' => "ສິນຄ້າບໍ່ຢູ່ໃນເງື່ອນໄຂການຄິດໄລ່ !"]);
                    }
                }else{ // ELSE BIG
                     
                     $w_price = ($request->large * $request->height * $request->longs)/5000;
                     $find_price = CalculatePrice::select('id','price')->where('min_val','<',$w_price)->where('max_val','>=',$w_price)
                                                        ->where('status',1)->where('cal_type_id',3)->where('distance_id',$request->dist_id)->where('del',1)->first();
                     if($find_price->id !=null) {
                         $cal_price = $find_price->price * $w_price;
                         $fun_id= $find_price->id;
                         if ((($request->r2=='COD') || ($request->insur=='TRUE')) && ($request->amount==0)){
                            return response()->json(['message' => "ກະລຸນາເພີ່ມລາຄາຂົນສົ່ງ ໃຫ້ຖືກຕ້ອງ!"]);
                        }else{
                            $th = 'TH'.date('Ymdms');
                            $matterail = new Matterail();
                            $matterail->code = $th;
                            $matterail->receive_id = $request->code;
                            $matterail->goods_id = $request->goods_type_id;
                            $matterail->product_type_id = $request->product_type_id;
                            $matterail->large = $request->large;
                            $matterail->height = $request->height;
                            $matterail->longs = $request->longs;
                            $matterail->weigh = $request->weigh;
                            $matterail->cal_price_id = $fun_id;
                            $matterail->currency_code = 'LAK';
                            $matterail->amount = $cal_price;
                            $matterail->cod_amount = $request->amount;
                            if($request->insur=='TRUE'){
                                $matterail->insur_amount= $request->amount * $in_rate;
                            }else{
                                $matterail->insur_amount=0;
                            }   
                            $matterail->pack_id = $request->pack;
                            $matterail->pack_amount = $request->pack_amount;     
                            $matterail->paid_type = $request->piadtype;
                            $matterail->paid_by = $request->piadtype;
                            $matterail->branch_id = Auth()->user()->branchname->id;
                            $matterail->usr_create = Auth()->user()->id;
                            $matterail->status ="P";
                            $matterail->save();
                
                            $lis_m = new ListMatterail();
                            $lis_m->rvcode = $request->code;
                            $lis_m->mcode = $th;
                            $lis_m->cal_price_id = $fun_id;
                            $lis_m->currency_code = $request->r1;
                            $lis_m->amount = $cal_price;
                            $lis_m->cod_amount = $request->amount;
                            if($request->insur=='TRUE'){
                                $lis_m->insur_amount= $request->amount * $in_rate;
                            }else{
                                $lis_m->insur_amount=0;
                            }    
                            $lis_m->pack_id = $request->pack;
                            $lis_m->pack_amount = $request->pack_amount;       
                            $lis_m->paid_type = $request->piadtype;
                            $lis_m->paid_by = $request->piadtype;
                            $lis_m->branch_id = auth()->user()->branchname->id;
                            $lis_m->usr_create = auth()->user()->id;
                            $lis_m->status ="P";
                            $lis_m->save();
                        }   
                    } else { 
                        return response()->json(['message' => "ສິນຄ້າບໍ່ຢູ່ໃນເງື່ອນໄຂການຄິດໄລ່ !"]);
                    }
                }
        }elseif($fprod->func_type=='FX'){
                $find_cal2 = CalculatePrice::select('calculate_prices.id as id','pf.price as price')
                            ->join('price_funcs as pf', 'calculate_prices.id', '=', 'pf.cal_price_id')   
                              //  ->where('calculate_prices.distance_id',$this->dist_id)
                                ->where('pf.currency_code',$request->r1)
                                ->where('calculate_prices.id',$fprod->cal_price_id)->where('del',1)->first();
                if(!empty($find_cal2->id)) {
                    $cal_price = $find_cal2->price;
                    $fun_id=$find_cal2->id;
                    if ((($request->r2=='COD') || ($request->insur=='TRUE')) && ($request->amount==0)){
                        return response()->json(['message' => "ກະລຸນາເພີ່ມລາຄາຂົນສົ່ງ ໃຫ້ຖືກຕ້ອງ!"]);
                    }else{
                        $th = 'TH'.date('Ymdms');
                        $matterail = new Matterail();
                        $matterail->code = $th;
                        $matterail->receive_id = $request->code;
                        $matterail->goods_id = $request->goods_type_id;
                        $matterail->product_type_id = $request->product_type_id;
                        $matterail->large = $request->large;
                        $matterail->height = $request->height;
                        $matterail->longs = $request->longs;
                        $matterail->weigh = $request->weigh;
                        $matterail->cal_price_id = $fun_id;
                        $matterail->currency_code = 'LAK';
                        $matterail->amount = $cal_price;
                        $matterail->cod_amount = $request->amount;
                        if($request->insur=='TRUE'){
                            $matterail->insur_amount= $request->amount * $in_rate;
                        }else{
                            $matterail->insur_amount=0;
                        }   
                        $matterail->pack_id = $request->pack;
                        $matterail->pack_amount = $request->pack_amount;      
                        $matterail->paid_type = $request->piadtype;
                        $matterail->paid_by = $request->piadtype;
                        $matterail->branch_id = Auth()->user()->branchname->id;
                        $matterail->usr_create = Auth()->user()->id;
                        $matterail->status ="P";
                        $matterail->save();
            
                        $lis_m = new ListMatterail();
                        $lis_m->rvcode = $request->code;
                        $lis_m->mcode = $th;
                        $lis_m->cal_price_id = $fun_id;
                        $lis_m->currency_code = $request->r1;
                        $lis_m->amount = $cal_price;
                        $lis_m->cod_amount = $request->amount;
                        if($request->insur=='TRUE'){
                            $lis_m->insur_amount= $request->amount * $in_rate;
                        }else{
                            $lis_m->insur_amount=0;
                        }    
                        $lis_m->pack_id = $request->pack;
                        $lis_m->pack_amount = $request->pack_amount;         
                        $lis_m->paid_type = $request->piadtype;
                        $lis_m->paid_by = $request->piadtype;
                        $lis_m->branch_id = auth()->user()->branchname->id;
                        $lis_m->usr_create = auth()->user()->id;
                        $lis_m->status ="P";
                        $lis_m->save();
                    }   
                } else { 
                    return response()->json(['message' => "ສິນຄ້າບໍ່ຢູ່ໃນເງື່ອນໄຂການຄິດໄລ່ !"]);
                }           
        }else{
                  $find_cal2 = CalculatePrice::select('calculate_prices.id as id','pf.price as price')
                                ->join('price_funcs as pf', 'calculate_prices.id', '=', 'pf.cal_price_id')
                                //->where('calculate_prices.distance_id',$this->dist_id)
                                ->where('pf.currency_code',$request->r1)
                                ->where('calculate_prices.id',$fprod->cal_price_id)->where('del',1)->first();
                  if(!empty($find_cal2->id) )  {
                    if($find_cal2->cal_type_id==1){
                        $cal_price= $v * $find_cal2->price;           
                    }else{
                        $cal_price= $request->weigh * $find_cal2->price;
                    }
                        $fun_id=$find_cal2->id;
                        if ((($request->r2=='COD') || ($request->insur=='TRUE')) && ($request->amount==0)){
                            return response()->json(['message' => "ກະລຸນາເພີ່ມລາຄາຂົນສົ່ງ ໃຫ້ຖືກຕ້ອງ!"]);
                        }else{
                            $th = 'TH'.date('Ymdms');
                            $matterail = new Matterail();
                            $matterail->code = $th;
                            $matterail->receive_id = $request->code;
                            $matterail->goods_id = $request->goods_type_id;
                            $matterail->product_type_id = $request->product_type_id;
                            $matterail->large = $request->large;
                            $matterail->height = $request->height;
                            $matterail->longs = $request->longs;
                            $matterail->weigh = $request->weigh;
                            $matterail->cal_price_id = $fun_id;
                            $matterail->currency_code = 'LAK';
                            $matterail->amount = $cal_price;
                            $matterail->cod_amount = $request->amount;
                            if($request->insur=='TRUE'){
                                $matterail->insur_amount= $request->amount * $in_rate;
                            }else{
                                $matterail->insur_amount=0;
                            }   
                            $matterail->pack_id = $request->pack;
                            $matterail->pack_amount = $request->pack_amount;    
                            $matterail->paid_type = $request->piadtype;
                            $matterail->paid_by = $request->piadtype;
                            $matterail->branch_id = Auth()->user()->branchname->id;
                            $matterail->usr_create = Auth()->user()->id;
                            $matterail->status ="P";
                            $matterail->save();
                
                            $lis_m = new ListMatterail();
                            $lis_m->rvcode = $request->code;
                            $lis_m->mcode = $th;
                            $lis_m->cal_price_id = $fun_id;
                            $lis_m->currency_code = $request->r1;
                            $lis_m->amount = $cal_price;
                            $lis_m->cod_amount = $request->amount;
                            if($request->insur=='TRUE'){
                                $lis_m->insur_amount= $request->amount * $in_rate;
                            }else{
                                $lis_m->insur_amount=0;
                            }    
                            $lis_m->pack_id = $request->pack;
                            $lis_m->pack_amount = $request->pack_amount;      
                            $lis_m->paid_type = $request->piadtype;
                            $lis_m->paid_by = $request->piadtype;
                            $lis_m->branch_id = auth()->user()->branchname->id;
                            $lis_m->usr_create = auth()->user()->id;
                            $lis_m->status ="P";
                            $lis_m->save();
                        }   
                    } else { 
                        return response()->json(['message' => "ສິນຄ້າບໍ່ຢູ່ໃນເງື່ອນໄຂການຄິດໄລ່ !"]);
                    }                                
        }  
    }

    public function postReceiveTransaction(Request $request)
    {
        $chekm= DB::table('matterails')
        ->select(DB::raw('count(receive_id) as c, sum(amount) as m, sum(cod_amount) as cm, sum(insur_amount) as ins,sum(pack_amount) as pkamt'))
        ->where('receive_id','=',$request->code)
        ->groupBy('receive_id')
        ->first();

        If(empty($chekm->c)){
            return response()->json(['message' => "ກະລຸນາເພີ່ມລາຍການສິນຄ້າກ່ອນ !"]);
        }else{
            $savebill = new ReceiveTransaction();
            $savebill->code = $request->code ;
            $savebill->type='SND_BILL';
            $savebill->valuedt=  date('Y-m-d', time());
            $savebill->branch_send = auth()->user()->branchname->id ;
            $savebill->customer_send = $request->cusid ;
            $savebill->branch_receive =$request->branch_id ;
            $savebill->customer_receive = $request->rcid;
            $savebill->pro_id = $request->pro_id;
            $savebill->dis_id = $request->dis_id;
            $savebill->vil_id= $request-> vil_id;
            $savebill->currency_code = 'LAK';
            $savebill->amount = $chekm->m;
            $savebill->service_type = $request->r2;
            $savebill->cod_amount = $chekm->cm;
            $savebill->insur = $request->insur;
            $savebill->insur_rate = 0.3;
            $savebill->insur_amount = $chekm->ins;
            $savebill->pack_amount = $chekm->pkamt;
            $savebill->paid_by= $request->piadtype;
            $savebill->creator_id=  auth()->user()->id;
            $savebill->branch_create_id = auth()->user()->branchname->id ;
            $savebill-> status= 'N';
            $savebill->save();

            Matterail::where('receive_id', '=', $request->code)->update(['status' => 'N']);

            return response()->json(['message' => "ບັນທຶກຂໍ້ມູນສຳເລັດ !"]);

        }
    }


    public function showbillreceive($code)
    {
        return response()->json([BillReceiveResource::collection(
            Matterail::where('receive_id', $code)->get()
            )],200);
    }

    public function showbillallreceive($code)
    {
        return response()->json([BillallReceiveResource::collection(
            ReceiveTransaction::where('code', $code)->get()
            )],200);
    }

    public function destroyorder ($id){
        $matterail = Matterail::find($id);
        if($matterail){
            // $lis_m = ListMatterail::where('rvcode',$request->rvcode)->where('mcode',$lis_m->mcode )->delete();
            $matterail->delete();
            return response()->json(['message'=>'ລົບສຳເລັດ'],200);
        }else{
            return response()->json(['message'=>'ລົບບໍ່ສຳເລັດ'],404);
        }
    }    

    

}