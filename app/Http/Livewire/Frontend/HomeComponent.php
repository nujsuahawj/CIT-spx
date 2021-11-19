<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\Web\Slider;
use App\Models\Web\Service;
use App\Models\Web\Testimonial;
use App\Models\Web\Page;
use App\Models\Settings\Branch;
use App\Models\Transaction\ReceiveTransaction;

class HomeComponent extends Component
{
    public $search, $data;

    public function render()
    {
        $sliders = Slider::where('status',1)->get();
        $services = Service::where('status',1)->take(4)->get();
        $testimonials = Testimonial::where('status',1)->get();
        $address = Branch::select('logo','company_name_la')->where('id',1)->get();

        //$pages = Page::select('short_des_la','short_des_en')->where('id',1)->first();

            $receivetransaction=ReceiveTransaction::select('receive_transactions.*','cr.name as crr','cr.phone as crphone') 
                ->join('customers as cr','receive_transactions.customer_receive','=','cr.id')
                ->where(function($query){
                    $query->where('receive_transactions.code',$this->data)
                    ->orWhere('cr.name', $this->data)
                    ->orWhere('cr.phone', $this->data);
                 })->get();

        
        return view('livewire.frontend.home-component', compact('sliders','services','testimonials','receivetransaction'))
        ->layout('layouts.frontend.base-frontend');
    }

    public function search()
    {
        $this->data = $this->search;
    }
}
