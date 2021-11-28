<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use DB;

class AuthApiController extends Controller
{
    public function apiregister(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'phone'=>'required|numeric|unique:users',
            'password'=>'required|min:6',
            'password_confirmation'=>'required|same:password',
        ],[
            'name.required'=>'ກະລຸນາໃສ່ຊື່ກ່ອນ!',
            'phone.required'=>'ໃສ່ເບີ້ໂທລະສັບກ່ອນ!',
            'phone.numeric' =>'ເບີ້ໂທຕ້ອງເປັນຕົວເລກ',
            'phone.unique'=>'ເບີ້ໂທນີ້ມີໃນລະບົບແລ້ວ',
            'password.required'=>'ໃສ່ລະຫັດຜ່ານກ່ອນ!',
            'password.min'=>'ລະຫັດຕ້ອງ 6 ຕົວຂື້ນໄປ',
            'password_confirmation.required' => 'ໃສ່ຢັ້ງຢືນລະຫັດຜ່ານກ່ອນ!',
            'password_confirmation.same' => 'ຢັ້ງຢືນລະຫັດຜ່ານບໍ່ຕົງກັນ!',
        ]);

        //$image = $request->image;
        //$imageName = time().$image->getClientOriginalName();

        $users = User::create([
            'code'=>'CUS'.date('Ymdhms'),
            'name'=>$request->name,
            'phone'=>$request->phone,
            'email'=>$request->email,
            'password'=> bcrypt($request->password),
            //'image'=>'images/profile/'.$imageName
        ]);
        //$image->move('images/profile/',$imageName);

        return response([
            'user'=> $users,
            'token'=> $users->createToken('secret')->plainTextToken
        ]);
    }
    public function apilogin(Request $request)
    {
        $request->validate([
            'phone'=>'required|numeric',
            'password'=>'required|min:6'
        ],[
            'phone.required'=>'ໃສ່ເບີ້ໂທລະສັບກ່ອນ!',
            'phone.numeric' =>'ເບີ້ໂທຕ້ອງເປັນຕົວເລກ',
            'password.required'=>'ໃສ່ລະຫັດຜ່ານກ່ອນ!',
            'password.min'=>'ລະຫັດຕ້ອງ 6 ຕົວຂື້ນໄປ'
        ]);

        if(Auth::attempt($request->all()))
        {
            return response([
                'user'=>auth()->user(),
                'token'=>auth()->user()->createToken('secret')->plainTextToken
            ],200);
        }
        else
        {
            return response([
                'message'=>'ຊື່ຜູ້ໃຊ້ ຫຼື ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ!'
            ],403);
        }
    }
    public function apilogout($id)
    {

        // Auth::user()->tokens->each(function($token, $key) {
        //     $token->delete();
        // });
        
        // return response([
        //     'message'=>'ອອກລະບົບສຳເລັດ!'
        // ], 200);

        // $id = auth()->user()->tokens;
        $logout = DB::table('personal_access_tokens')->where('id', $id)->delete();

        return response([
            'message'=>'ອອກລະບົບສຳເລັດ!'
        ], 200);
    }
    public function apiuser()
    {
        return response([
            'user'=>auth()->user()
        ],200);
    }

    public function update(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(),[
                'name'=>'required',
                'phone'=>'required',
                'image'=>'nullable|image',
            ],[
                'name.required'=>'ໃສ່ຊື່ ແລະ ນາມສະກຸນກ່ອນ!',
                'phone.required'=>'ໃສ່ເບີ້ໂທລະສັບກ່ອນ!',
                'image.image'=>'ທ່ານໃສ່ບໍ່ຖືກຮູບແບບຮູບ!'
            ]);

            if($validator->fails()){
                $error = $validator->errors()->all()[0];
                return response()->json(['status'=>'false','message'=>$error, 'data'=>[]],422);
            }else
            {
                $user = User::find($request->user()->id);
                $user->name = $request->name;
                $user->phone = $request->phone;
                $user->email = $request->email;
                $user->address = $request->address;

                if($request->image && $request->image->isValid()){
                    $file_name = time().'.'. $request->image->extension();
                    $request->image->move(public_path('images/profile'), $file_name);
                    $path = "images/profile/$file_name";
                    $user->image = $path;
                }elseif($request->input('password'))
                {
                    $user->password = bcrypt($request->password);
                }

                $user->update();

                return response()->json(['status'=>'true','message'=>"ແກ້ໄຂຂໍ້ມູນສຳເລັດ!",'data'=>$user]);
            }
        }
        catch(\Exception $e)
        {
            return response()->json(['status'=>'false','message'=>$e->getMessage(),'data'=>[]],500);
        }
    }

}
