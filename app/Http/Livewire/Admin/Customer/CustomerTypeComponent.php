<?php

namespace App\Http\Livewire\Admin\Customer;

use Livewire\Component;
use Livewire\WithPagination;

class CustomerTypeComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public  $hiddenId, $name, $parent_id;
    
    public $search;
    
    public function render()
    {
        return view('livewire.admin.customer.customer-type-component')->layout('layouts.base');
    }
}
