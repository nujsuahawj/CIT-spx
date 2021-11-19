<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\Web\Page;

class TermConditionComponent extends Component
{
    public function render()
    {
        $pages = Page::where('id',2)->first();
        return view('livewire.frontend.term-condition-component', compact('pages'))
        ->layout('layouts.frontend.base-frontend');
    }
}
