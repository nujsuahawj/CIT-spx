<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LoginComponent extends Component
{
    public $phone, $password;

    public function render()
    {
        return view('livewire.admin.login-component')->layout('layouts.baselogin');
    }

    protected $rules = [
        'phone'=>'required|min:8|numeric',
        'password'=>'required'
    ];
    protected $messages = [
        'phone.required'=>'ໃສ່ເບີ້ໂທລະສັບຂອງທ່ານກ່ອນ!',
        'phone.numeric'=>'ທ່ານໃສ່ເບີ້ໂທບໍ່ຖືກຮູບແບບ!',
        'phone.min'=>'ເບີ້ໂທລະສັບຕ້ອງ 8 ຕົວເລກ!',
        //'phone.max'=>'ເບີ້ໂທລະສັບບໍ່ຕ້ອງຫຼາຍກວ່າ 8 ຕົວເລກ!',
        'password.required' => 'ໃສ່ລະຫັດຜ່ານກ່ອນ!'
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function login()
    {
        $this->validate();
        if(Auth::attempt([
            'phone'=> $this->phone,
            'password'=> $this->password
        ]))
        {
            return redirect(route('admin.dashboard'));
        }else
        {
            //dd('login fails');
            //return redirect(route('login'));
            session()->flash('message', 'ຂໍ້ມູນເຂົ້າລະບົບ ບໍ່ຖືກຕ້ອງ!ກະລຸນາລອງໃໝ່');
        }
    }

}
