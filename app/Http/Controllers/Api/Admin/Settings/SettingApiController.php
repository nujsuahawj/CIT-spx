<?php

namespace App\Http\Controllers\Api\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; use App\Models\Settings\Role;
use App\Models\Settings\CalculatorPriceKg; use App\Models\Settings\CalculatorPriceOther;
use App\Models\Settings\Village; use App\Models\Settings\District; use App\Models\Settings\Province;
use App\Models\Settings\Dividend; use App\Models\Settings\Cod; use App\Models\Settings\Exchange;
use App\Models\Settings\GoodsType; use App\Models\Settings\ProductType;
use App\Models\Settings\Payment; use App\Models\Settings\PaymentType; use App\Models\Settings\Tax; 
use App\Models\Condition\Vihicle; use App\Models\Condition\VihicleType; use App\Models\Transaction;; 

class SettingApiController extends Controller
{
    //ສິດນຳໃຊ້ທັງໝົດ
    public function getRoles()
    {
        return response([
            'data'=> Role::select('id','name')->get()
        ],200);
    }
    //ລູກຄ້າທັງໝົດ
    public function getCustomers()
    {
        return response([
            'data'=> User::select('id','code','name','phone','email','address','branch_id','role_id')->where('del',1)->where('role_id',6)->get()
        ],200);
    }
    //ເງື່ອນໄຂລາຄາເປັນ Kg
    public function getCalculatorPriceKgs()
    {
        return response([
            'data'=> CalculatorPriceKg::all()
        ],200);
    }
    //ເງື່ອນໄຂຄິດໄລ່ແບບອື່ນໆ
    public function getCalculatorPriceOthers()
    {
        return response([
            'data'=> CalculatorPriceOther::all()
        ],200);
    }
    //ບ້ານ
    public function getVillage()
    {
        return response([
            'data'=> Village::select('id','name','pro_id','dis_id')->where('del',1)->get()
        ],200);
    }
    //ເມືອງ
    public function getDistrict()
    {
        return response([
            'data'=> District::select('id','name','pro_id')->where('del',1)->get()
        ],200);
    }
    //ແຂວງ
    public function getProvince()
    {
        return response([
            'data'=> Province::select('id','name')->where('del',1)->get()
        ],200);
    }
    //ເງື່ອນໄຂເງິນປັນຜົນ
    public function getDividend()
    {
        return response([
            'data'=> Dividend::select('id','name','percent','note')->get()
        ],200);
    }
    //ເງື່ອໄຂຄິດໄລ່ ບໍລິການ COD
    public function getCod()
    {
        return response([
            'data'=> Cod::select('id','code','name','percent')->get()
        ],200);
    }
    //ອັດຕາແລກປ່ຽນ
    public function getExchange()
    {
        return response([
            'data'=> Exchange::select('id','currency_one','rate_one','currency_two','rate_two')->get()
        ],200);
    }
    //ປະເພດສິນຄ້າ
    public function getGoodsType()
    {
        return response([
            'data'=> GoodsType::select('id','name')->get()
        ],200);
    }
    public function getGoodsTypeById($id)
    {
        return response([
            'data'=> GoodsType::find($id)
        ],200);
    }

    //ປະເພດເຄື່ອງຝາກ
    public function getProductType()
    {
        return response([
            'data'=> ProductType::select('id','goods_id','name')->get()
        ],200);
    }
    public function getProductTypeById($id)
    {
        return response([
            'data'=> ProductType::find($id)
        ],200);
    }

    //ຮູບແບບຊຳລະ
    public function getPayment()
    {
        return response([
            'data'=> Payment::select('id','name')->get()
        ],200);
    }
    //ປະເພດຊຳລະ
    public function getPaymentType()
    {
        return response([
            'data'=> PaymentType::select('id','name')->get()
        ],200);
    }
    //ອາກອນລາຍໄດ້ທີ່ຕ້ອງຫັກ
    public function getTax()
    {
        return response([
            'data'=> Tax::select('id','name','percent')->get()
        ],200);
    }
    //ຂໍ້ມູນລົດ
    public function getVihicle()
    {
        return response([
            'data'=> Vihicle::select('id','code','name','vihicle_type_id','plate_number','series_number','power_number','road_fee_date','technic_date','insurance_date','note','active')->get()
        ],200);
    }
    //ປະເພດລົດ
    public function getVihicleType()
    {
        return response([
            'data'=> VihicleType::select('id','name')->get()
        ],200);
    }

}
