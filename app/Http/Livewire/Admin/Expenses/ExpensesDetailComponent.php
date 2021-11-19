<?php

namespace App\Http\Livewire\Admin\Vihicle;

use Livewire\Component;
use Livewire\WithPagination;

class ExpensesDetailComponent extends Component
{
	use WithPagination;
	protected $PaginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.admin.expenses.expenses-component');
    }
}
