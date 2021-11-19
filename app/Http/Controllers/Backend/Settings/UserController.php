<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings\Branch;
use App\Models\Settings\Role;
use App\Models\Settings\Employee;
use App\Models\Transaction\ReceiveTransaction;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::orderBy('id','desc')->where('del',1)->get();
        return view('backend.settings.user.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Role::all();
        $employee = Employee::where('del',1)->get();
        $branch = Branch::where('del',1)->get();
        return view('backend.settings.user.create', compact('role','employee','branch'));
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
            'name'=>'required|min:3',
            'email'=>'required|email|unique:users',
            'phone'=>'required|numeric|unique:users',
            'password'=>'required|min:6',
            'password_confirmation'=>'required|same:password',
            'role_id'=>'required',
        ],[
            'name.required'=>'ໃສ່ຊື່ຜູ້ໃຊ້ກ່ອນ!',
            'name.min'=>'ຊື່ຜູ້ໃຊ້ຕ້ອງຫຼາຍກວ່າ 3 ຕົວ!',
            'email.unique'=>'ທີ່ຢູ່ Email ນີ້ມີໃນລະບົບແລ້ວ!',
            'email.required' => 'ໃສ່ Email ກ່ອນ!',
            'email.email' => 'ຮູບແບບ Email ບໍ່ຖືກຕ້ອງ!',
            'phone.unique'=>'ເບີໂທນີ້ມີໃນລະບົບແລ້ວ!',
            'phone.required' => 'ໃສ່ເບີໂທກ່ອນ!',
            'phone.numeric' => 'ເບີ້ໂທຕ້ອງແມ່ນໂຕເລກ',
            'password.required' => 'ໃສ່ລະຫັດຜ່ານກ່ອນ!',
            'password.min' => 'ລະຫັດຜ່ານຕ້ອງ 6 ຕົວຂື້ນໄປ!',
            'password_confirmation.required' => 'ໃສ່ຢັ້ງຢືນລະຫັດຜ່ານກ່ອນ!',
            'password_confirmation.same' => 'ຢັ້ງຢືນລະຫັດຜ່ານບໍ່ຕົງກັນ!',
            'role_id.required'=>'ເລືອກສິດນຳໃຊ້ກ່ອນ!',
        ]);

        $image = $request->image;
        if(!empty($image)){
            $imageName = time().$image->getClientOriginalName();
            User::create([
                'code'=>'CUS'.date('Ymdhms'),
                'name'=> $request->name,
                'phone'=> $request->phone,
                'email'=> $request->email,
                'address'=> $request->address,
                'password'=> bcrypt($request->password),
                'role_id'=>$request->role_id,
                'emp_id'=>$request->emp_id,
                'branch_id'=>$request->branch_id,
                'image'=>'images/profile/'.$imageName
            ]);
            $image->move('images/profile/',$imageName);
        }else{
            User::create([
                'code'=>'CUS'.date('Ymdhms'),
                'name'=> $request->name,
                'phone'=> $request->phone,
                'email'=> $request->email,
                'address'=> $request->address,
                'password'=> bcrypt($request->password),
                'role_id'=>$request->role_id,
                'emp_id'=>$request->emp_id,
                'branch_id'=>$request->branch_id
            ]);
        }
        
        return redirect(route('user.index'))->with('success','ເພີ່ມຂໍ້ມູນໃໝ່ສຳເລັດ!');

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
        $user = User::find($id);
        $role = Role::all();
        $employee = Employee::where('del',1)->get();
        $branch = Branch::where('del',1)->get();
        return view('backend.settings.user.edit', compact('user','role','employee','branch'));
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
        $user = User::find($id);
        $request->validate([
            'name'=>'required|min:3',
            'phone'=>'required|numeric',
            'role_id'=>'required',
        ],[
            'name.required'=>'ໃສ່ຊື່ຜູ້ໃຊ້ກ່ອນ!',
            'name.min'=>'ຊື່ຜູ້ໃຊ້ຕ້ອງຫຼາຍກວ່າ 3 ຕົວ!',
            'phone.required' => 'ໃສ່ເບີໂທກ່ອນ!',
            'phone.numeric' => 'ເບີ້ໂທຕ້ອງແມ່ນໂຕເລກ',
            'role_id.required'=>'ເລືອກສິດນຳໃຊ້ກ່ອນ!',
        ]);
        
        if($request->input('password'))
        {
            if($request->has('image')){
                $image = $request->image;
                $imageName = time().$image->getClientOriginalName();
                $image->move('images/profile/',$imageName);
                $user_data = [
                    'name'=> $request->name,
                    'email'=> $request->email,
                    'phone'=> $request->phone,
                    'address'=> $request->address,
                    'password'=> bcrypt($request->password),
                    'role_id'=>$request->role_id,
                    'emp_id'=>$request->emp_id,
                    'image'=>'images/profile/'.$imageName
                ];
            }else{
                $user_data = [
                    'name'=> $request->name,
                    'email'=> $request->email,
                    'phone'=> $request->phone,
                    'address'=> $request->address,
                    'password'=> bcrypt($request->password),
                    'role_id'=>$request->role_id,
                    'emp_id'=>$request->emp_id,
                ];
            }
        }else{
            if($request->has('image')){
                $image = $request->image;
                $imageName = time().$image->getClientOriginalName();
                $image->move('images/profile/',$imageName);
                $user_data = [
                    'name'=> $request->name,
                    'email'=> $request->email,
                    'phone'=> $request->phone,
                    'address'=> $request->address,
                    'role_id'=>$request->role_id,
                    'emp_id'=>$request->emp_id,
                    'image'=>'images/profile/'.$imageName
                ];
            }else{
                $user_data = [
                    'name'=> $request->name,
                    'email'=> $request->email,
                    'phone'=> $request->phone,
                    'address'=> $request->address,
                    'role_id'=>$request->role_id,
                    'emp_id'=>$request->emp_id,
                ];
            }
        }
        $user->update($user_data);
        return redirect(route('user.index'))->with('success','ບັນທຶກຂໍ້ມູນສຳເລັດ!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $receive_tran = ReceiveTransaction::where('creator_id', $id)->first();
        if(!empty($receive_tran)){
            return redirect()->back()->with('warning','ບໍ່ສາມາດລົບ ຂໍ້ມູນນີ້ໄດ້!');
        }else{
            $user = User::find($id);
            $user->delete();
            return redirect()->back()->with('success','ລຶບຂໍ້ມູນສຳເລັດ!');
        }
        
    }
}
