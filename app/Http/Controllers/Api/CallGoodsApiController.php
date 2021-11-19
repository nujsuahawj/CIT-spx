<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CallGoodsResource;
use App\Models\CallGoods;

class CallGoodsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $request = CallGoods::all();
        return response()->json([CallGoodsResource::collection(CallGoods::all()->where('user_id', auth()->user()->id))],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'vihicle_type_id'=>'required',
            'goods_types_id'=>'required',
            'product_type_id'=>'required',
            'longitude'=>'required',
            'latitude'=>'required',
            'product_count'=>'required',
            'appoinment_time'=>'required',

        ]);

        $callgoods = new CallGoods();
        $callgoods -> vihicle_type_id = $request -> vihicle_type_id;
        $callgoods -> goods_types_id = $request -> goods_types_id;
        $callgoods -> product_type_id = $request -> product_type_id;
        $callgoods -> longitude = $request -> longitude;
        $callgoods -> latitude = $request -> latitude;
        $callgoods -> product_count = $request -> product_count;
        $callgoods -> large = $request -> large;
        $callgoods -> height = $request -> height;
        $callgoods -> longs = $request -> longs;
        $callgoods -> weight = $request -> weight;
        $callgoods -> detal = $request -> detal;
        $callgoods -> appoinment_time = $request -> appoinment_time;
        $callgoods -> user_id = auth()->user()->id;
        $callgoods -> status = $request->status;
        $results = $callgoods->save();
        return response()->json(['status'=>'true','message'=>"ເພີມຊໍ້ມູນສຳເລັດ"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $callgoods = CallGoods::find($id);
        if($callgoods)
        {
            return response()->json([$callgoods],200);
        }
        else
        {
            return response()->json(['message'=>'ບໍ່ມີບັນທຶກ'],404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'note'=>'required',
        ]);
            $callgoods = CallGoods::find($id);
            if($callgoods){
                $callgoods->note = $request->note;
                $callgoods->status = 0;
                $callgoods->update();
                return response()->json(['message'=>"ຍົກເລີກຂໍ້ມູນສຳເລັດ!",'data'=>$callgoods],200);
            }else
            {
                return response()->json(['message'=>"ເກີດຂໍ້ຜິດພາດ!",'data'=>$callgoods],404);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return CallGoods::destroy($id);
    }
}
