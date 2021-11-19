<?php

namespace App\Http\Livewire\Admin\CallGood;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\CallGoods;

class CallGoodComponent extends Component
{
    use WithFileUploads; use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $hiddenId, $search;

    public function render()
    {
        $call_goods = CallGoods::orderBy('id')->paginate(10);
        return view('livewire.admin.call-good.call-good-component',compact('call_goods'))->layout('layouts.base');
    }
}
