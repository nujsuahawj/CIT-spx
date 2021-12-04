<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings\Branch;
use App\Models\Settings\BranchType;
use App\Models\Settings\Dividend;
use App\Models\Settings\Tax;
use App\Models\Settings\Province;
use App\Models\Settings\District;
use App\Models\Settings\Village;
use App\Models\User;
use App\Models\Staff\Employee;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branch = Branch::where('del',1)->orderBy('id','desc')->get();
        return view('backend.settings.branch.index', compact('branch'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branch_code = Branch::orderBy('id','desc')->first()->code; //. str_pad($lastIncreament + 1, 3, 0, STR_PAD_LEFT)
        $code = $branch_code;
        $branch_type = BranchType::all();
        $dividends = Dividend::all();
        $taxs = Tax::all();
        $province = Province::all();
        $district = District::all();
        $village = Village::all();
        return view('backend.settings.branch.create', compact('code','branch_type','dividends','taxs','province','district','village'));
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
            'code'=>'required|unique:branches',
            'company_name_la'=>'required',
        ],[
            'code.required'=>'ໃສ່ລະຫັດສາຂາກ່ອນ!',
            'code.unique'=>'ລະຫັດນີ້ໄດ້ມີແລ້ວ! ກະລຸນາບວກ 1 ຂື້ນ',
            'company_name_la.required'=>'ກະລຸນາໃສ່ຊື່ສາຂາ ພາສາລາວ ກ່ອນ!',
        ]);

        if($request->has('logo'))
        {
            $logo = $request->logo;
            $logoname = time().$logo->getClientOriginalName();
            $logo->move('images/', $logoname);
            Branch::create([
                'code' => $request->code,
                'logo'=>'images/'.$logoname,
                'company_name_la'=>$request->company_name_la,
                'company_name_en'=>$request->company_name_en,
                'address_la'=>$request->address_la,
                'address_en'=>$request->address_en,
                'phone'=>$request->phone,
                'pro_id'=> $request->pro_id,
                'dis_id'=> $request->dis_id,
                'vill_id'=> $request->vill_id,
                'branch_type_id'=>$request->branch_type_id,
                'dividend_id'=>$request->dividend_id,
                'tax_id'=> $request->tax_id,
                'sign1'=>$request->sign1,
                'sign2'=>$request->sign2,
                'sign3'=>$request->sign3,
                'sign4'=>$request->sign4,
                'whatsapp'=>$request->whatsapp,
                'facebook_fanpage'=>$request->facebook_fanpage,
                'youtube'=>$request->youtube,
                'google_map'=>$request->google_map,
                'longitude'=>$request->longitude,
                'latitude'=>$request->latitude,
                'bill_header'=>$request->bill_header,
                'bill_footer'=>$request->bill_footer,
                'active'=>$request->active,
            ]);
        }
        elseif($request->has('company_photo'))
        {
            $company_photo = $request->company_photo;
            $company_photoName = time().$company_photo->getClientOriginalName();
            $company_photo->move('images/', $company_photoName);
            Branch::create([
                'code' => $request->code,
                'company_photo'=>'images/'.$company_photoName,
                'company_name_la'=>$request->company_name_la,
                'company_name_en'=>$request->company_name_en,
                'address_la'=>$request->address_la,
                'address_en'=>$request->address_en,
                'phone'=>$request->phone,
                'pro_id'=> $request->pro_id,
                'dis_id'=> $request->dis_id,
                'vill_id'=> $request->vill_id,
                'branch_type_id'=>$request->branch_type_id,
                'dividend_id'=>$request->dividend_id,
                'tax_id'=> $request->tax_id,
                'sign1'=>$request->sign1,
                'sign2'=>$request->sign2,
                'sign3'=>$request->sign3,
                'sign4'=>$request->sign4,
                'whatsapp'=>$request->whatsapp,
                'facebook_fanpage'=>$request->facebook_fanpage,
                'youtube'=>$request->youtube,
                'google_map'=>$request->google_map,
                'longitude'=>$request->longitude,
                'latitude'=>$request->latitude,
                'bill_header'=>$request->bill_header,
                'bill_footer'=>$request->bill_footer,
                'active'=>$request->active,
            ]);
        }
        else
        {
            Branch::create([
                'code' => $request->code,
                'company_name_la'=>$request->company_name_la,
                'company_name_en'=>$request->company_name_en,
                'address_la'=>$request->address_la,
                'address_en'=>$request->address_en,
                'phone'=>$request->phone,
                'pro_id'=> $request->pro_id,
                'dis_id'=> $request->dis_id,
                'vill_id'=> $request->vill_id,
                'branch_type_id'=>$request->branch_type_id,
                'dividend_id'=>$request->dividend_id,
                'tax_id'=> $request->tax_id,
                'sign1'=>$request->sign1,
                'sign2'=>$request->sign2,
                'sign3'=>$request->sign3,
                'sign4'=>$request->sign4,
                'whatsapp'=>$request->whatsapp,
                'facebook_fanpage'=>$request->facebook_fanpage,
                'youtube'=>$request->youtube,
                'google_map'=>$request->google_map,
                'longitude'=>$request->longitude,
                'latitude'=>$request->latitude,
                'bill_header'=>$request->bill_header,
                'bill_footer'=>$request->bill_footer,
                'active'=>$request->active,
            ]);
        }
        
        return redirect(route('branch.index'))->with('success','ເພີ່ມຂໍ້ມູນໃໝ່ສຳເລັດ!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $branch = Branch::find($id);
        $branch_type = BranchType::all();
        $dividends = Dividend::all();
        $taxs = Tax::all();
        $province = Province::all();
        $district = District::all();
        $village = Village::all();
        return view('backend.settings.branch.edit', compact('branch','branch_type','dividends','taxs','province','district','village'));
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
        $branch = Branch::find($id);
        $request->validate([
            'company_name_la'=>'required',
        ],[
            'company_name_la.required'=>'ກະລຸນາໃສ່ຊື່ສາຂາ ພາສາລາວ ກ່ອນ!',
        ]);
        if($request->has('logo'))
        {
            $logo = $request->logo;
            $logoname = time().$logo->getClientOriginalName();
            $logo->move('images/', $logoname);
            $branch_data = [
                'code' => $request->code,
                'logo'=>'images/'.$logoname,
                'company_name_la'=>$request->company_name_la,
                'company_name_en'=>$request->company_name_en,
                'address_la'=>$request->address_la,
                'address_en'=>$request->address_en,
                'phone'=>$request->phone,
                'pro_id'=> $request->pro_id,
                'dis_id'=> $request->dis_id,
                'vill_id'=> $request->vill_id,
                'branch_type_id'=>$request->branch_type_id,
                'dividend_id'=>$request->dividend_id,
                'tax_id'=> $request->tax_id,
                'sign1'=>$request->sign1,
                'sign2'=>$request->sign2,
                'sign3'=>$request->sign3,
                'sign4'=>$request->sign4,
                'whatsapp'=>$request->whatsapp,
                'facebook_fanpage'=>$request->facebook_fanpage,
                'youtube'=>$request->youtube,
                'google_map'=>$request->google_map,
                'longitude'=>$request->longitude,
                'latitude'=>$request->latitude,
                'bill_header'=>$request->bill_header,
                'bill_footer'=>$request->bill_footer,
                'active'=>$request->active,
            ];
        }
        elseif($request->has('company_photo'))
        {
            $company_photo = $request->company_photo;
            $company_photoName = time().$company_photo->getClientOriginalName();
            $company_photo->move('images/', $company_photoName);
            $branch_data = [
                'code' => $request->code,
                'company_photo'=>'images/'.$company_photoName,
                'company_name_la'=>$request->company_name_la,
                'company_name_en'=>$request->company_name_en,
                'address_la'=>$request->address_la,
                'address_en'=>$request->address_en,
                'phone'=>$request->phone,
                'pro_id'=> $request->pro_id,
                'dis_id'=> $request->dis_id,
                'vill_id'=> $request->vill_id,
                'branch_type_id'=>$request->branch_type_id,
                'dividend_id'=>$request->dividend_id,
                'tax_id'=> $request->tax_id,
                'sign1'=>$request->sign1,
                'sign2'=>$request->sign2,
                'sign3'=>$request->sign3,
                'sign4'=>$request->sign4,
                'whatsapp'=>$request->whatsapp,
                'facebook_fanpage'=>$request->facebook_fanpage,
                'youtube'=>$request->youtube,
                'google_map'=>$request->google_map,
                'longitude'=>$request->longitude,
                'latitude'=>$request->latitude,
                'bill_header'=>$request->bill_header,
                'bill_footer'=>$request->bill_footer,
                'active'=>$request->active,
            ];
            //dd($branch_data);
        }
        else
        {
            $branch_data = [
                'code' => $request->code,
                'company_name_la'=>$request->company_name_la,
                'company_name_en'=>$request->company_name_en,
                'address_la'=>$request->address_la,
                'address_en'=>$request->address_en,
                'phone'=>$request->phone,
                'pro_id'=> $request->pro_id,
                'dis_id'=> $request->dis_id,
                'vill_id'=> $request->vill_id,
                'branch_type_id'=>$request->branch_type_id,
                'dividend_id'=>$request->dividend_id,
                'tax_id'=> $request->tax_id,
                'sign1'=>$request->sign1,
                'sign2'=>$request->sign2,
                'sign3'=>$request->sign3,
                'sign4'=>$request->sign4,
                'whatsapp'=>$request->whatsapp,
                'facebook_fanpage'=>$request->facebook_fanpage,
                'youtube'=>$request->youtube,
                'google_map'=>$request->google_map,
                'longitude'=>$request->longitude,
                'latitude'=>$request->latitude,
                'bill_header'=>$request->bill_header,
                'bill_footer'=>$request->bill_footer,
                'active'=>$request->active,
            ];
        }
        $branch->update($branch_data);
        return redirect(route('branch.index'))->with('success','ບັນທຶກຂໍ້ມູນໃໝ່ສຳເລັດ!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('branch_id', $id)->first();
        $employee = Employee::where('branch_id', $id)->first();
        if(!empty($user) || !empty($employee)){
            return redirect()->back()->with('error','ບໍ່ສາມາດລຶບໄດ້! ຂໍ້ມູນນີ້ໄດ້ຖືກໃຊ້ງານຢູ່');
        }else{
            $branch = Branch::find($id);
            $branch->delete();
            return redirect()->back()->with('success','ລຶບຂໍ້ມູນໃໝ່ສຳເລັດ!');
        }
        
    }
}
