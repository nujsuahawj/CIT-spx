<?php

namespace App\Http\Livewire\Admin\Products;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Catalog;
use App\Models\Product;

class CatalogComponent extends Component
{
    use WithFileUploads; use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $hiddenId, $parent_id, $name, $search, $search_by_cat;

    public function mount()
    {
        $this->code = $code = 'CIT'.date('Ymdms');
        $this->search_by_cat;
    }

    public function render()
    {
        $allcatalogs = Catalog::all();
        $count_all_products = Product::where('del',1)->count();

        $products = Product::orderBy('id','desc')->where('del',1)
            ->where(function($query){
                $query->where('code', 'like', '%' .$this->search. '%')
                ->orWhere('name', 'like', '%' .$this->search. '%');
            })->where('catalog_id', 'like', '%' .$this->search_by_cat. '%')->paginate(5);
        
        $catalogs = Catalog::with('subcatalog')->whereNull('parent_id')->get();
        return view('livewire.admin.products.catalog-component', compact('allcatalogs','count_all_products','products','catalogs'))->layout('layouts.base');
    }
    //Reset field Catalog
    public function resetField()
    {
        $this->parent_id = '';
        $this->name = '';
    }

    //Validate realtime Catalog
    protected $rules = [
        'name'=>'required'
    ];
    protected $messages = [
        'name.required'=>'ໃສ່ຊື່ໝວດໝູ່ກ່ອນ!'
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    //Search by Catalog
    public function searchByCatalog($ids)
    {
        //dd($ids);
        $singleData = Product::find($ids);
        $this->search_by_cat = $singleData->id;
        //dd($this->search_by_cat);
    }
    //Show and store Catalog
    public function create()
    {
        $this->resetField();
        $this->dispatchBrowserEvent('show-modal-add');
        $this->validate();
    }
    public function store()
    {
        $this->validate();
        $catalog = new Catalog();
        $catalog->parent_id = $this->parent_id;
        $catalog->name = $this->name;
        $catalog->save();

        $this->dispatchBrowserEvent('hide-modal-add');
        $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
        $this->resetField();
    }

    //Show and Update Catalog
    public function edit($ids)
    {
        $this->dispatchBrowserEvent('show-modal-edit');
        $singleData = Catalog::find($ids);
        $this->parent_id = $singleData->parent_id;
        $this->name = $singleData->name;
        $this->hiddenId = $singleData->id;
    }
    public function update()
    {
        //$this->validate();
        $ids = $this->hiddenId;
        $catalog = Catalog::find($ids);
        if($catalog->parent_id = null)
        {
            $catalog->name = $this->name;
        }else
        {
            $catalog->parent_id = $this->parent_id;
            $catalog->name = $this->name;
        }
        $catalog->save();

        $this->dispatchBrowserEvent('hide-modal-edit');
        $this->emit('alert', ['type' => 'success', 'message' => 'ບັນທຶກຂໍ້ມູນສຳເລັດ!']);
        $this->resetField();
    }

    //Show and Delete Catalog
    public function showDestroyCatalog($ids)
    {
        $this->dispatchBrowserEvent('show-modal-delete');
        $singleData = Catalog::find($ids);
        $this->hiddenId = $singleData->id;
    }
    public function destroy($ids)
    {
        $ids = $this->hiddenId;
        $catalog = Catalog::find($ids);
        $catalog->delete();
        $this->dispatchBrowserEvent('hide-modal-delete');
        $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
        $this->resetField();
    }

    //Show and store Product
    public  $code, $product_name, $short_des, $des, $image, $catalog_id, $buy_price=0, $dearler_price=0,
            $sale_price=0, $online_price=0,$vat=0, $color, $size, $unit, $min_qty=0, $note;
    public function showAddProduct()
    {
        $this->resetProductForm();
        $this->dispatchBrowserEvent('show-modal-add-product');
    }
    public function resetProductForm()
    {
        $this->product_name = ''; $this->catalog_id = ''; $this->buy_price = 0; $this->dearler_price = 0; $this->sale_price = 0; $this->online_price = 0;
        $this->vat = 0; $this->vat =0; $this->color =''; $this->size =''; $this->unit =''; $this->min_qty =0; $this->note ='';
    }
    public function storeProduct()
    {
        $this->validate([
            'code'=>'required|unique:products',
            'name'=>'required'
        ],[
            'code.required'=>'ໃສ່ລະຫັດບາໂຄດສິນຄ້າກ່ອນ!',
            'code.unique'=>'ລະຫັດນີ້ມີໃນລະບົບແລ້ວ!',
            'name.required'=>'ໃສ່ຊື່ສິນຄ້າກ່ອນ!'
        ]);

        if($this->image != null)
        {
            $product = new Product();
            $product->code = $this->code; //str_replace(',','',$request->debit),
            $product->name = $this->name;
            $product->catalog_id = $this->parent_id;
            $product->buy_price = str_replace(',','',$this->buy_price);
            //$product->dearler_price = str_replace(',','',$this->dearler_price);
            $product->sale_price = str_replace(',','',$this->sale_price);
            $product->online_price = str_replace(',','',$this->online_price);
            $product->vat = $this->vat;
            $product->color = $this->color;
            $product->size = $this->size;
            $product->unit = $this->unit;
            $product->min_qty = $this->min_qty;
            $product->short_des = $this->short_des;
            $product->des = $this->des;
            $product->image = $this->image->store('upload/products');
        }
        else
        {
            $product = new Product();
            $product->code = $this->code; //str_replace(',','',$request->debit),
            $product->name = $this->name;
            $product->catalog_id = $this->parent_id;
            $product->buy_price = str_replace(',','',$this->buy_price);
            //$product->dearler_price = str_replace(',','',$this->dearler_price);
            $product->sale_price = str_replace(',','',$this->sale_price);
            $product->online_price = str_replace(',','',$this->online_price);
            $product->vat = $this->vat;
            $product->color = $this->color;
            $product->size = $this->size;
            $product->unit = $this->unit;
            $product->min_qty = $this->min_qty;
            $product->short_des = $this->short_des;
            $product->des = $this->des;
        }

        $product->save();
        
        $this->dispatchBrowserEvent('hide-modal-add-product');
        $this->emit('alert', ['type' => 'success', 'message' => 'ເພີ່ມຂໍ້ມູນຂໍ້ມູນສຳເລັດ!']);
        //return redirect(route('admin.catalog'));
        $this->resetProductForm();
    }

    //Show and Update Product
    public function showEditProduct($ids)
    {
        $this->resetProductForm();
        $this->dispatchBrowserEvent('show-modal-edit-product');
        $singleData = Product::find($ids);
        $this->hiddenId = $singleData->id;
        $this->code = $singleData->code;
        $this->name = $singleData->name;
        $this->parent_id = $singleData->catalog_id;
        $this->buy_price = $singleData->buy_price;
        //$this->dearler_price = $singleData->dearler_price;
        $this->sale_price = $singleData->sale_price;
        $this->online_price = $singleData->online_price;
        $this->vat = $singleData->vat;
        $this->color = $singleData->color;
        $this->size = $singleData->size;
        $this->unit = $singleData->unit;
        $this->min_qty = $singleData->min_qty;
        $this->note = $singleData->note;
        $this->short_des = $singleData->short_des;
        $this->des = $singleData->des;
    }
    public function updateProduct()
    {
        $ids = $this->hiddenId;
        $product = Product::find($ids);

        if($this->image !=null)
        {
            $product->code = $this->code; //str_replace(',','',$request->debit),
            $product->name = $this->name;
            $product->catalog_id = $this->parent_id;
            $product->buy_price = str_replace(',','',$this->buy_price);
            //$product->dearler_price = str_replace(',','',$this->dearler_price);
            $product->sale_price = str_replace(',','',$this->sale_price);
            $product->online_price = str_replace(',','',$this->online_price);
            $product->vat = $this->vat;
            $product->color = $this->color;
            $product->size = $this->size;
            $product->unit = $this->unit;
            $product->min_qty = $this->min_qty;
            $product->short_des = $this->short_des;
            $product->des = $this->des;
            $product->image = $this->image->store('upload/products');
        } 
        else
        {
            $product->code = $this->code; //str_replace(',','',$request->debit),
            $product->name = $this->name;
            $product->catalog_id = $this->parent_id;
            $product->buy_price = str_replace(',','',$this->buy_price);
            //$product->dearler_price = str_replace(',','',$this->dearler_price);
            $product->sale_price = str_replace(',','',$this->sale_price);
            $product->online_price = str_replace(',','',$this->online_price);
            $product->vat = $this->vat;
            $product->color = $this->color;
            $product->size = $this->size;
            $product->unit = $this->unit;
            $product->min_qty = $this->min_qty;
            $product->short_des = $this->short_des;
            $product->des = $this->des;
        }
        //dd($product);
        $product->save();
        
        $this->dispatchBrowserEvent('hide-modal-edit-product');
        $this->emit('alert', ['type' => 'success', 'message' => 'ແກ້ໄຂຂໍ້ມູນສຳເລັດ!']);
        $this->resetProductForm();
    }

    //Show and Delete Product
    public function showDestroyProduct($ids)
    {
        $this->dispatchBrowserEvent('show-modal-delete-product');
        $singleData = Product::find($ids);
        $this->hiddenId = $singleData->id;
    }
    public function destroyProduct()
    {
        $ids = $this->hiddenId;
        $product = Product::find($ids);
        $product->del = 0;
        $product->save();
        $this->dispatchBrowserEvent('hide-modal-delete-product');
        $this->emit('alert', ['type' => 'success', 'message' => 'ລຶບຂໍ້ມູນສຳເລັດ!']);
    }
}
