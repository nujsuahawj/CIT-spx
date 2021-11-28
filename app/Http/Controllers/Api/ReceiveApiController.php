<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction\ReceiveTransaction;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ReceiveResource;
use App\Http\Resources\SearchReceiveResource;
use App\Http\Resources\BillReceiveResource;
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
            'customer_receive'=>'required','goods_type_id'=>'required','product_type_id'=>'required','large'=>'numeric|min:0','height'=>'numeric|min:0',
            'longs'=>'numeric|min:0','weigh'=>'numeric|min:0'
        ],[
            'goods_type_id.required'=>'ເລືອກປະເພດເຄື່ອງ','product_type_id.required'=>'ເລືອກໝວດໝູ່',
            'large.numeric'=>'ຕື່ມຄ່າ>=0','large.min'=>'ຕື່ມຄ່າ>=0',
            'height.numeric'=>'ຕື່ມຄ່າ>=0','height.min'=>'ຕື່ມຄ່າ>=0',
            'longs.numeric'=>'ຕື່ມຄ່າ>=0','longs.min'=>'ຕື່ມຄ່າ>=0',
            'weigh.numeric'=>'ຕື່ມຄ່າ>=0','weigh.min'=>'ຕື່ມຄ່າ>=0'
            
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

    // public function showorder($id){
    //     $matterail = Matterail::find($id);
    //     if($matterail)
    //     {
    //         return response()->json([$matterail],200);
    //     }
    //     else
    //     {
    //         return response()->json(['message'=>'ບໍ່ມີບັນທຶກ'],404);
    //     }
    // }

    public function showbillreceive($code)
    {
        return response()->json([BillReceiveResource::collection(
            Matterail::where('receive_id', $code)->get()
            )],200);
    }

    public function destroyorder ($id){
        $matterail = Matterail::find($id);
        
        if($matterail)
        {
            // $lis_m = ListMatterail::where('rvcode',$request->rvcode)->where('mcode',$lis_m->mcode )->delete();
            $matterail->delete();
            return response()->json(['message'=>'ລົບສຳເລັດ'],200);
        }
        else
        {
            return response()->json(['message'=>'ລົບບໍ່ສຳເລັດ'],404);
        }
        
    }    

    

}