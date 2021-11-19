<?php

namespace App\Http\Livewire\Admin\Customer;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Condition\Customer;
use App\Models\Settings\CustomerType;
use App\Models\Settings\Branch;
//use App\Models\Village;
//use App\Models\District;
//use App\Models\Province;

use App\Models\Settings\Province;
use App\Models\Settings\District;
use App\Models\Settings\Village;


class CustomerComponent extends Component
{
    use WithFileUploads; use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $hiddenId, $parent_id, $name, $search,$status, $branch_search, $search_by_cat;
    public $pro_id = null;
    public $dis_id = null;
    public $vil_id = null;
    public $districts = [];
    public $villages = [];
  

    public function mount()
    {
        $this->code = $code = 'C'.date('Ymdms');
        $this->search_by_cat;
    }

    public function render()
    {
        //dd($branchid);
        $branchid  = Auth()->user()->branchname->id;
        $provinces = Province::where('del', 1)->get();
        $dist = District::where('del', 1)->get();
        $vill = Village::where('del', 1)->get();

        if(!empty($this->pro_id)){
            $this->districts = District::where('pro_id', $this->pro_id)->get();
        }

        if(!empty($this->dis_id)){
            $this->villages = Village::where('dis_id', $this->dis_id)->get();
        }

        if($branchid == 1){
            $branch = Branch::where('id',$branchid)->get();
            $customertypes = CustomerType::all();
            $count_all_customers = Customer::where('del',1)->count();
            if($this->branch_search == 0){

                $customers = Customer::select('customers.*','provinces.name as proname','districts.name as disname','villages.name as vilname')
                ->leftJoin('provinces', 'customers.pro_id', '=', 'provinces.id')
                ->leftJoin('districts', 'customers.dis_id', '=', 'districts.id')
                ->leftJoin('villages', 'customers.vil_id', '=', 'villages.id')
                ->where('customers.del',1)
                ->where(function($query){
                 $query->where('customers.code', 'like', '%' .$this->search. '%')
                ->orWhere('customers.name', 'like', '%' .$this->search. '%');
                 })->where('customers.cus_type_id', 'like', '%' .$this->search_by_cat. '%')->paginate(10);


           }else{
            $customers = Customer::select('customers.*','provinces.name as proname','districts.name as disname','villages.name as vilname')
            ->leftJoin('provinces', 'customers.pro_id', '=', 'provinces.id')
            ->leftJoin('districts', 'customers.dis_id', '=', 'districts.id')
            ->leftJoin('villages', 'customers.vil_id', '=', 'villages.id')
            ->where('customers.del',1)
                ->where(function($query){
                    $query->where('customers.code', 'like', '%' .$this->search. '%')
                    ->orWhere('customers.name', 'like', '%' .$this->search. '%');
               })->where('customers.cus_type_id', 'like', '%' .$this->search_by_cat. '%')
                ->where('customers.branch_id', 'like', '%' .$this->branch_search. '%')->paginate(10);
           }
        
        }else{
            $branch = Branch::where('id', $branchid)->get();
            $customertypes = CustomerType::all();
            $count_all_customers = Customer::where('del',1)->where('branch_id',$branchid)->count();
            $customers = Customer::select('customers.*','provinces.name as proname','districts.name as disname','villages.name as vilname')
            ->leftJoin('provinces', 'customers.pro_id', '=', 'provinces.id')
            ->leftJoin('districts', 'customers.dis_id', '=', 'districts.id')
            ->leftJoin('villages', 'customers.vil_id', '=', 'villages.id')
            ->where('customers.del',1)
                ->where('customers.branch_id',$branchid)
                ->where(function($query){
                    $query->where('customers.code', 'like', '%' .$this->search. '%')
                    ->orWhere('customers.name', 'like', '%' .$this->search. '%');
                })->where('customers.cus_type_id', 'like', '%' .$this->search_by_cat. '%')->paginate(5);
         
        }
        return view('livewire.admin.customer.customer-component', compact('branch','customertypes','count_all_customers','customers','provinces','dist','vill'))->layout('layouts.base');
    }

    public function updatedpro_id($pro_id)
      {
         $this->districts = District::where('pro_id', $pro_id)->get();
      }

    
    //Reset field CustomerType
    public function resetField()
    {
        $this->parent_id = '';
        $this->name = '';
    }

    //Validate realtime CustomerType
    protected $rules = [
        'name'=>'required',
        'status'=>'required'
    ];
    protected $messages = [
        'name.required'=>'ໃສ່ຊື່ປະເພດລູກຄ້າກ່ອນ!',
        'status.required'=>'ກະລຸນາເລືອກສະຖານະການນຳໃຊ້'
    ];
 
    //Show and store CustomerType
    public function create()
    {
        $this->resetField();
        $this->dispatchBrowserEvent('show-modal-add');
        //$this->validate();
    }
    public function store()
    {
        $this->validate();
        $customertype = new CustomerType();
        $customertype->parent_id = $this->parent_id;
        $customertype->name = $this->name;
        $customertype->status = $this->status;
        $customertype->save();

        $this->dispatchBrowserEvent('hide-modal-add');
        $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
        $this->resetField();
    }

    //Show and Update CustomerType
    public function edit($ids)
    {
        $this->dispatchBrowserEvent('show-modal-edit');
        $singleData = CustomerType::find($ids);
        $this->parent_id = $singleData->parent_id;
        $this->name = $singleData->name;
        $this->status=$singleData->status;
        $this->hiddenId = $singleData->id;
    }
    public function update()
    {
        //$this->validate();
        $ids = $this->hiddenId;
        $customertype = CustomerType::find($ids);
        if($customertype->parent_id = null)
        {
            $customertype->name = $this->name;
        }else
        {
            $customertype->parent_id = $this->parent_id;
            $customertype->name = $this->name;
            $customertype->status = $this->status;
        }
        $customertype->save();

        $this->dispatchBrowserEvent('hide-modal-edit');
        $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
        $this->resetField();
    }

    //Show and Delete CustomerType
    public function showDestroyCustomerType($ids)
    {
        $this->dispatchBrowserEvent('show-modal-delete');
        $singleData = CustomerType::find($ids);
        $this->hiddenId = $singleData->id;
        $this->name = $singleData->name;
    }
    public function destroy($ids)
    {
        $ids = $this->hiddenId;
        $customertype = CustomerType::find($ids);
        $customertype->delete();
        $this->dispatchBrowserEvent('hide-modal-delete');
        $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
        $this->resetField();
    }

    //Show and store Customer
    public  $code, $phone, $email,  $bod, $cus_type_id, $branch_id, $note;

    public function showAddCustomer()
    {
        $this->resetCustomerForm();
        $this->dispatchBrowserEvent('show-modal-add-customer');
        $this->dispatchBrowserEvent('showAddCustomer');
    }
    public function resetCustomerForm()
    {
        $this->name = ''; $this->phone = ''; $this->email; $this->bod; $this->cus_type_id;
        $this->branch_id; $this->note ='';
    }
    public function storeCustomer()
    {
        $this->validate([
            'code'=>'required|unique:products',
            'name'=>'required',
            'cus_type_id'=>'required',
            'phone'=>'required'
        ],[
            'code.required'=>'ໃສ່ລະຫັດບາໂຄດສິນຄ້າກ່ອນ!',
            'code.unique'=>'ລະຫັດນີ້ມີໃນລະບົບແລ້ວ!',
            'name.required'=>'ໃສ່ຊື່ລູກຄ້າກ່ອນ!',
            'cus_type_id.required'=>'ກະລຸນາເລືອກປະເພດລູກຄ້າ',
            'phone.required'=>'ກະລຸນາຕື່ມເລກໝາຍເບີໂທລະສັບ'

        ]);

        $customer = new Customer();
        $customer->code = $this->code; //str_replace(',','',$request->debit),
        $customer->name = $this->name;
        $customer->phone = $this->phone;
        $customer->email = $this->email;
        $customer->pro_id = $this->pro_id;
        $customer->dis_id = $this->dis_id;
        $customer->vil_id = $this->vil_id;
        $customer->bod = $this->bod;
        $customer->cus_type_id = $this->cus_type_id;
        $customer->branch_id =Auth()->user()->branchname->id;
        $customer->note = $this->note;
        $customer->save();
        
        $this->dispatchBrowserEvent('hide-modal-add-customer');
        $this->emit('alert', ['type' => 'success', 'message' => 'ເພີ່ມຂໍ້ມູນຂໍ້ມູນສຳເລັດ!']);
        //return redirect(route('admin.catalog'));
        $this->resetCustomerForm();
    }

    //Show and Update Customer
    public function showEditCustomer($ids)
    {
        $this->resetCustomerForm();
        $this->dispatchBrowserEvent('show-modal-edit-customer');
        $singleData = Customer::find($ids);
        $this->hiddenId = $singleData->id;
        $this->code = $singleData->code;
        $this->name = $singleData->name;
        $this->phone = $singleData->phone;
        $this->email = $singleData->email;
        $this->pro_id = $singleData->pro_id;
        $this->dis_id = $singleData->dis_id;
        $this->vil_id = $singleData->vil_id;
        $this->bod = $singleData->bod;
        $this->parent_id = $singleData->cus_type_id;
        $this->branch_id = $singleData->branch_id;
        $this->note = $singleData->note;

    }
    public function updateCustomer()
    {
        $ids = $this->hiddenId;
        $customer = Customer::find($ids);
            $customer->code = $this->code; //str_replace(',','',$request->debit),
            $customer->name = $this->name;
            $customer->phone = $this->phone;
            $customer->email = $this->email;
            $customer->pro_id = $this->pro_id;
            $customer->dis_id = $this->dis_id;
            $customer->vil_id = $this->vil_id;
            $customer->bod = $this->bod;
            $customer->cus_type_id = $this->parent_id;
            $customer->branch_id = $this->branch_id;
            $customer->note = $this->note;
        
        //dd($Customer);
        $customer->save();
        
        $this->dispatchBrowserEvent('hide-modal-edit-customer');
        $this->emit('alert', ['type' => 'success', 'message' => 'ແກ້ໄຂຂໍ້ມູນສຳເລັດ!']);
        $this->resetCustomerForm();
    }

    //Show and Delete Customer
    public function showDestroyCustomer($ids)
    {
        $this->dispatchBrowserEvent('show-modal-delete-customer');
        $singleData = Customer::find($ids);
        $this->hiddenId = $singleData->id;
    }
    public function destroyCustomer()
    {
        $ids = $this->hiddenId;
        $customer = Customer::find($ids);
        $customer->del = 0;
        $customer->save();
        $this->dispatchBrowserEvent('hide-modal-delete-customer');
        $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
    }

}
