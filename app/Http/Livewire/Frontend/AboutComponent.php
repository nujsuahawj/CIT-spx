<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\Web\Page;
use App\Models\Staff\Employee;

class AboutComponent extends Component
{
    public function render()
    {
        $pages = Page::select('image','title_la','title_en','short_des_la','short_des_en')->where('id',1)->first();
        $employees = Employee::select('photo','firstname','lastname','position_id')->take(3);
        return view('livewire.frontend.about-component', compact('pages','employees'))
        ->layout('layouts.frontend.base-frontend');
    }
}
