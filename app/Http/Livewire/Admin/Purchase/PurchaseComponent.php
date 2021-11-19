<?php

namespace App\Http\Livewire\Admin\Purchase;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Purchase;
use App\Models\Member;
use App\Models\Branch;

class PurchaseComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $hiddenId, $search_member, $search_branch, $search_date, $search_by_approve;
    public function render()
    {
        $all_member = Member::where('del',1)->where('branch_id', auth()->user()->branchname->id)->get();
        $all_branch = Branch::all();

        $purchase = Purchase::orderBy('id','desc')->where('del',1)->where('branch_id', auth()->user()->branchname->id)
        ->where('member_id', 'like', '%' .$this->search_member . '%')
        ->where('branch_id', 'like', '%' .$this->search_branch . '%')
        ->where('approve_status', 'like', '%' .$this->search_by_approve . '%')
        ->where('created_at', 'like', '%' .$this->search_date . '%')
        ->paginate(10);
        
        return view('livewire.admin.purchase.purchase-component', compact('purchase','all_member','all_branch'))
        ->layout('layouts.base');
    }
}
