<?php

namespace App\Http\Livewire\Admin\Products;

use Livewire\Component;
use Livewire\WithPagination;

class ProductComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public  $hiddenId, $code, $name, $short_des, $des, $image, $cat_id, $buy_price_lak, $dearler_price_lak, $sall_price_lak, $online_price_lak,
            $buy_price_thb, $dearler_price_thb, $sall_price_thb, $online_price_thb, $vat, $color, $size, $unit, $min_qty, $note;
    
    public $search;

    public function render()
    {
        
        return view('livewire.admin.products.product-component')->layout('layouts.base');
    }
}
