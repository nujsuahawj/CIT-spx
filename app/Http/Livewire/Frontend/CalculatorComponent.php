<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\Settings\CalculatorPriceKg;
use App\Models\Settings\CalculatorPriceOther;

class CalculatorComponent extends Component
{
    public $weight = 0, $length = 0, $width = 0, $height = 0;
    
    public function render()
    {
        $price_kg = CalculatorPriceKg::select('price_local','price_south','price_north')->where('id',1)->first();
        $price_other = CalculatorPriceOther::select('condition1','condition2')->where('id',1)->first();
        return view('livewire.frontend.calculator-component', compact('price_kg','price_other'))
        ->layout('layouts.frontend.base-frontend');
    }

}
