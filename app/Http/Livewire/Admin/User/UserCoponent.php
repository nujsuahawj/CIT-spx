<?php

namespace App\Http\Livewire\Admin\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Settings\Role;
use DB;

class UserCoponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $hidenId, $user, $email, $phone, $password, $password_confirmation, $role_id;
    public $search;

    public function render()
    {
        $roles = Role::all();
        $users = User::query()
            ->orderBy('id','desc')
            ->orWhere('name', 'like', '%'. $this->search . '%')
            ->orWhere('phone', 'like', '%'. $this->search . '%')
            ->orWhere('email', 'like', '%'. $this->search . '%')
            ->where('del',1)->paginate(5);
        return view('livewire.admin.user.user-coponent',[
            'users'=> $users, 'roles'=>$roles,
        ])->layout('layouts.base');
    }

    public function resetField()
    {
        $this->email = '';
        $this->phone ='';
        $this->password = '';
        $this->password_confirmation = '';
        $this->role_id = '';
    }

    protected $rules = [
        'name'=>'required|min:3',
        'email'=>'required|email|unique:users',
        'phone'=>'required|numeric|unique:users',
        'password'=>'required|min:6',
        'password_confirmation'=>'required|same:password',
        'role_id'=>'required'
    ];
    protected $messages = [
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
        'role_id.required'=>'ເລືອກສິດນຳໃຊ້ກ່ອນ!'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    //Update and Store
    public function store()
    {
        //Update if select
        $updateId = $this->hidenId;
        
        if($updateId > 0){
            $this->validate([
                'name'=>'required|min:3',
                'email'=>'required|email',
                'phone'=>'required|numeric',
                'role_id'=>'required'
            ],[
                'name.required'=>'ໃສ່ຊື່ຜູ້ໃຊ້ກ່ອນ!',
                'name.min'=>'ຊື່ຜູ້ໃຊ້ຕ້ອງຫຼາຍກວ່າ 3 ຕົວ!',
                'email.required' => 'ໃສ່ Email ກ່ອນ!',
                'email.email' => 'ຮູບແບບ Email ບໍ່ຖືກຕ້ອງ!',
                'phone.required' => 'ໃສ່ເບີໂທກ່ອນ!',
                'phone.numeric' => 'ເບີ້ໂທຕ້ອງແມ່ນໂຕເລກ',
                'role_id.required'=>'ເລືອກສິດນຳໃຊ້ກ່ອນ!'
            ]);
            try
            {
                $user_data = [
                    'name'=>$this->user,
                    'phone' => $this->phone,
                    'email'=> $this->email,
                    'password'=> bcrypt($this->password),
                    'role_id'=> $this->role_id
                ];
            }
            catch(Throwable $e)
            {
                $user_data = [
                    'name'=>$this->user,
                    'phone' => $this->phone,
                    'email'=> $this->email,
                    'role_id'=> $this->role_id
                ];
            }

            DB::table('users')->where('id', $updateId)->update($user_data);

        }
        else //Store
        {
            $validatedData = $this->validate();
            $validatedData['password'] = bcrypt($validatedData['password']);
            User::create($validatedData);
        } 
        $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
        $this->resetField();
    }

    //Show Edit by ID
    public function edit($ids)
    {
        $usersUpdateId = User::find($ids);
        $this->user = $usersUpdateId->user;
        $this->phone = $usersUpdateId->phone; 
        $this->email = $usersUpdateId->email;
        $this->role_id = $usersUpdateId->role_id;   
        $this->hidenId = $usersUpdateId->id;     
    }

    //Destroy by ID
    public function destroy($ids)
    {
        $users = User::find($ids);
        //dd($users);
        $users->del = 0;
        $users->save();
        $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
    }

}
