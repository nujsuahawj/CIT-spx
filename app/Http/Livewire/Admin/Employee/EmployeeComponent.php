<?php

namespace App\Http\Livewire\Admin\Employee;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings\Branch;
use App\Models\Settings\Province;
use App\Models\Settings\District;
use App\Models\Settings\Village;
use App\Models\Staff\Employee;
use App\Models\Staff\SaralyType;
use App\Models\Staff\Payroll;
use App\Models\Staff\PayrollDetail;
use App\Models\Staff\PayrollTransection;

class EmployeeComponent extends Component
{
    use WithFileUploads; use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $hiddenId, $name, $salary, $search, $branch_search, $search_by_stype;
    public $pros_id = null;
    public $diss_id = null;
    public $vils_id = null;
    public $districts = [];
    public $villages = [];

    public function mount()
    {
        $this->code = $code = 'EMP'.date('Ymdms');
        $this->search_by_stype;
    }

    public function render()
    {
        $salarytypes = SaralyType::select('id','name','salary')->where('del', 1)->get();
        $count_all_enmp = Employee::where('del', 1)->count();
        $allbranch = Branch::all();
        if(!empty($this->pro_id)){
            $this->districts = District::where('pro_id', $this->pro_id)->get();
        }
        if(!empty($this->dis_id)){
            $this->villages = Village::where('dis_id', $this->dis_id)->get();
        }
        if(Auth()->user()->rolename->name == 'admin'){
         if($this->branch_search == 0){
            if(!empty($this->search_by_stype)){
                $employees = Employee::orderBy('id','desc')->where('del',1)
                ->where(function($query){
                    $query->where('code', 'like', '%' .$this->search. '%')
                    ->orWhere('firstname', 'like', '%' .$this->search. '%');
                })->where('saraly_type_id', 'like', '%' .$this->search_by_stype. '%')->paginate(10);
            }else{
                $employees = Employee::orderBy('id','desc')->where('del',1)
                ->where(function($query){
                    $query->where('code', 'like', '%' .$this->search. '%')
                    ->orWhere('firstname', 'like', '%' .$this->search. '%');
                })->paginate(10);
            }

            }else{
                if(!empty($this->search_by_stype)){
                    $employees = Employee::orderBy('id','desc')->where('del',1)
                    ->where(function($query){
                        $query->where('code', 'like', '%' .$this->search. '%')
                        ->orWhere('firstname', 'like', '%' .$this->search. '%');
                    })->where('saraly_type_id', 'like', '%' .$this->search_by_stype. '%')
                     ->where('branch_id', 'like', '%' .$this->branch_search. '%')->paginate(10);
                }else{
                    $employees = Employee::orderBy('id','desc')->where('del',1)
                    ->where(function($query){
                        $query->where('code', 'like', '%' .$this->search. '%')
                        ->orWhere('firstname', 'like', '%' .$this->search. '%');
                    })->where('branch_id', 'like', '%' .$this->branch_search. '%')->paginate(10);
                }

            }
        }else{
            if(!empty($this->search_by_stype)){
                    $employees = Employee::orderBy('id','desc')->where('del',1)
                    ->where(function($query){
                        $query->where('code', 'like', '%' .$this->search. '%')
                        ->orWhere('firstname', 'like', '%' .$this->search. '%');
                    })->where('saraly_type_id', 'like', '%' .$this->search_by_stype. '%')
                     ->where('branch_id', Auth()->user()->branchname->id)->paginate(10);
                }else{
                    $employees = Employee::orderBy('id','desc')->where('del',1)
                    ->where(function($query){
                        $query->where('code', 'like', '%' .$this->search. '%')
                        ->orWhere('firstname', 'like', '%' .$this->search. '%');
                    })->where('branch_id', Auth()->user()->branchname->id)->paginate(10);
                }
        }
        return view('livewire.admin.employee.employee-component', compact('count_all_enmp','allbranch','employees','salarytypes'))->withProvinces(Province::where('del',1)->get())->withDistricts(District::where('del',1)->get())->withVillages(Village::where('del',1)->get())->layout('layouts.base');
    }

protected $rules = [
        'name'=>'required',
        'salary'=>'required'
    ];
    protected $messages = [
        'name.required'=>'ໃສ່ຊື່ປະເພດເງິນເດືອນກ່ອນ!',
        'salary.required'=>'ໃສ່ຈຳນວນເງິນເດືອນກ່ອນ'
    ];

    public function searchBySalaryType($ids)
    {
        $singleData = Employee::find($ids);
        if(!empty($singleData)){
            $this->search_by_stype = $singleData->id;
        }else{
            $this->search_by_stype = '';
        }
        
    }

    public function resetField()
    {
        $this->name = '';
        $this->salary = '';
    }

    //Show and store SalaryType
    public function create()
    {
        $this->resetField();
        $this->dispatchBrowserEvent('show-modal-add');
        $this->validate();
    }
    public function store()
    {
        $this->validate();
        $salarytype = new SaralyType();
        $salarytype->name = $this->name;
        $salarytype->salary = str_replace(',','',$this->salary);
        $salarytype->save();

        return redirect(route('admin.employee'));
        $this->dispatchBrowserEvent('hide-modal-add');
        $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
        $this->resetField();
    }
    //Show and Update SalaryType
    public function edit($ids)
    {
        $this->dispatchBrowserEvent('show-modal-edit');
        $singleData = SaralyType::find($ids);
        $this->name = $singleData->name;
        $this->salary = $singleData->salary;
        $this->hiddenId = $singleData->id;
    }
    public function update()
    {
        //$this->validate();
        $ids = $this->hiddenId;
        $salarytype = SaralyType::find($ids);
        $salarytype->name = $this->name;
        $salarytype->salary = str_replace(',','',$this->salary);
        $salarytype->save();

        return redirect(route('admin.employee'));
        $this->dispatchBrowserEvent('hide-modal-edit');
        $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
        $this->resetField();
    }
    //Show and Delete SalaryType
    public function showDestroySalaryType($ids)
    {
        $this->dispatchBrowserEvent('show-modal-delete');
        $singleData = SaralyType::find($ids);
        $this->hiddenId = $singleData->id;
    }
    public function destroy($ids)
    {
        $ids = $this->hiddenId;
        $salarytype = SaralyType::find($ids);
        $emp = Employee::all()->where('saraly_type_id',$ids)->first();
        // dd($emp);
        if(!empty($emp)){
            $this->dispatchBrowserEvent('hide-modal-delete');
            $this->emit('alert',['type' => 'warning','message'=>'ບໍ່ສາມາດລຶບລາຍການນີ້ໄດ້! ກະລຸນາກວດຄືນຂໍ້ມູນພະນັກງານທີ່ຍັງໃຊ້ຕຳແໜ່ງນີ້ຢູ່!']);
            $this->dispatchBrowserEvent('close-modal-delete');
        }else{
            $salarytype->delete();
            $this->dispatchBrowserEvent('hide-modal-delete');
            $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
            $this->resetField();
        }
        return redirect(route('admin.employee'));
    }
    public  $code, $firstname, $lastname, $bod, $card_id, $card_enddate, $address, $phone, $vill_id,
            $dis_id, $pro_id, $image, $start_date, $end_date, $saraly_type_id, $note, $branch_id;
    public function showAddEmployee()
    {
        $this->resetEmployeeForm();
        $this->dispatchBrowserEvent('show-modal-add-employee');
    }
    public function resetEmployeeForm()
    {
        $this->firstname = ''; $this->lastname = ''; $this->phone = '';  $this->saraly_type_id = ''; $this->bod = ''; $this->card_id = ''; $this->address = ''; $this->note =''; $this->saraly_type_id = ''; $this->branch_id =''; 
    }

    public function storeEmployee()
    {
        $this->validate([
            'code'=>'required',
            'firstname'=>'required',
            'lastname'=>'required',
            'pro_id'=>'required',
            'dis_id'=>'required',
            'vill_id'=>'required',
            'saraly_type_id'=>'required',
            'branch_id'=>'required',
        ],[
            'code.required'=>'ໃສ່ລະຫັດບາໂຄດສະມາຊິກກ່ອນກ່ອນ!',
            'firstname.required'=>'ໃສ່ຊື່ສະມາຊິກກ່ອນ!',
            'lastname.required'=>'ໃສ່ນາມສະກຸນສະມາຊິກກ່ອນ!',
            'pro_id.required'=>'ກະລຸນາເລືອກແຂວງກ່ອນ!',
            'dis_id.required'=>'ກະລຸນາເລືອກເມືອງກ່ອນ!',
            'vill_id.required'=>'ກະລຸນາເລືອກບ້ານກ່ອນ!',
            'saraly_type_id.required'=>'ກະລຸນາເລືອກຂັ້ນເງິນເດືອນກ່ອນ!',
            'branch_id.required'=>'ກະລຸນາເລືອກສາຂາກ່ອນ!',
        ]);

        $userid = Auth::user()->name;

        $employee = new Employee();
        $employee->code = $this->code;
        $employee->firstname = $this->firstname;
        $employee->lastname = $this->lastname;
        if(!empty($this->bod)){
            $employee->bod = $this->bod;
        }else{
            $employee->bod = date('Y-m-d');
        }
        $employee->card_id = $this->card_id;
        $employee->card_enddate = $this->card_enddate;
        $employee->address = $this->address;
        $employee->phone = $this->phone;
        $employee->vill_id = $this->vill_id;
        $employee->dis_id = $this->dis_id;
        $employee->pro_id = $this->pro_id;
        if($this->image == ""){
            $employee->photo = "";
        }else{
            $employee->photo = $this->image->store('upload/employee');
        }
        $employee->start_date = $this->start_date;
        $employee->end_date = $this->end_date;
        $employee->position_id = $this->saraly_type_id;
        $employee->user_id = Auth()->user()->id;
        if($userid == "admin"){
            $employee->branch_id = $this->branch_id;
        }else{
            $employee->branch_id = Auth()->user()->branchname->id;
        }
        $employee->note = $this->note;
        $employee->save();
        
        $this->dispatchBrowserEvent('hide-modal-add-employee');
        $this->emit('alert', ['type' => 'success', 'message' => 'ເພີ່ມຂໍ້ມູນຂໍ້ມູນສຳເລັດ!']);
        //return redirect(route('admin.catalog'));
        $this->resetEmployeeForm();
    }

    //Show and Update Employee
    public function showEditEmployee($ids)
    {
        $this->resetEmployeeForm();
        $this->dispatchBrowserEvent('show-modal-edit-employee');
        $singleData = Employee::find($ids);
        $this->hiddenId = $singleData->id;
        $this->code = $singleData->code;
        $this->firstname = $singleData->firstname;
        $this->lastname = $singleData->lastname;
        $this->phone = $singleData->phone;
        $this->address = $singleData->address;
        $this->bod = $singleData->bod;
        $this->card_id = $singleData->card_id;
        $this->card_enddate = $singleData->card_enddate;
        $this->unit = $singleData->unit;
        $this->pro_id = $singleData->pro_id;
        $this->dis_id = $singleData->dis_id;
        $this->vill_id = $singleData->vill_id;
        $this->start_date = $singleData->start_date;
        $this->end_date = $singleData->end_date;
        $this->saraly_type_id = $singleData->position_id;
        $this->branch_id = $singleData->branch_id;
        $this->note = $singleData->note;
    }
    public function updateEmployee()
    {
        $ids = $this->hiddenId;
        $employee = Employee::find($ids);

        $userid = Auth::user()->name;

        if($this->image !=null)
        {
            $employee->code = $this->code;
            $employee->firstname = $this->firstname;
            $employee->lastname = $this->lastname;
            $employee->bod = $this->bod;
            $employee->card_id = $this->card_id;
            $employee->card_enddate = $this->card_enddate;
            $employee->address = $this->address;
            $employee->phone = $this->phone;
            $employee->vill_id = $this->vill_id;
            $employee->dis_id = $this->dis_id;
            $employee->pro_id = $this->pro_id;
            $employee->photo = $this->image->store('upload/employee');
            $employee->start_date = $this->start_date;
            $employee->end_date = $this->end_date;
            $employee->position_id = $this->saraly_type_id;
            $employee->branch_id = $this->branch_id;
            $employee->note = $this->note;
        } 
        else
        {
            $employee->code = $this->code;
            $employee->firstname = $this->firstname;
            $employee->lastname = $this->lastname;
            $employee->bod = $this->bod;
            $employee->card_id = $this->card_id;
            $employee->card_enddate = $this->card_enddate;
            $employee->address = $this->address;
            $employee->phone = $this->phone;
            $employee->vill_id = $this->vill_id;
            $employee->dis_id = $this->dis_id;
            $employee->pro_id = $this->pro_id;
            $employee->start_date = $this->start_date;
            $employee->end_date = $this->end_date;
            $employee->position_id = $this->saraly_type_id;
            $employee->branch_id = $this->branch_id;
            $employee->note = $this->note;
        }
        //dd($member);
        $employee->save();
        
        $this->dispatchBrowserEvent('hide-modal-edit-employee');
        $this->emit('alert', ['type' => 'success', 'message' => 'ແກ້ໄຂຂໍ້ມູນສຳເລັດ!']);
        $this->resetEmployeeForm();
    }

    //Show and Delete Employee
    public function showDestroyEmployee($ids)
    {
        $this->dispatchBrowserEvent('show-modal-delete-employee');
        $singleData = Employee::find($ids);
        $this->hiddenId = $singleData->id;
    }
    public function destroyEmployee()
    {
        $ids = $this->hiddenId;
        $employee = Employee::find($ids);
        $payr = PayrollDetail::where('emp_id', $ids)->first();
        if(!empty($payr)){
            $this->dispatchBrowserEvent('hide-modal-delete-employee');
            $this->emit('alert',['type' => 'warning','message'=>'ບໍ່ສາມາດລຶບລາຍການນີ້ໄດ້! ກະລຸນາກວດຄືນຂໍ້ມູນພະນັກງານທີ່ໄດ້ເບີກເງິນເດືອນ!']);
            $this->dispatchBrowserEvent('close-modal-delete');
        }else{
            if(file_exists($employee->photo)){
                unlink($employee->photo);
                $employee->delete();
                $this->dispatchBrowserEvent('hide-modal-delete-employee');
                $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
            }else{
                $employee->delete();
                $this->dispatchBrowserEvent('hide-modal-delete-employee');
                $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
            }

        }
    }

    public function EmployeeDetail($id)
    {
        $employee = Employee::find($id);
        return redirect(route('admin.employee_detail', $id));
    }
}
