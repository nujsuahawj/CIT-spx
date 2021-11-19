<?php

namespace App\Http\Livewire\Admin\Vihicle;

use Livewire\Component;
use Livewire\WithPagination;

class VihicleComponent extends Component
{
	use WithPagination;
	protected $PaginationTheme = 'bootstrap';

	public $hiddenId, $name, $status;

	public $search;

    public function render()
    {
        return view('livewire.admin.vihicle.vihicle-component');
    }
}
