<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\Web\Message;
use App\Models\Settings\Branch;

class ContactComponent extends Component
{
    public function render()
    {
        $branchs = Branch::select('logo','company_name_la','company_name_en','phone','address_la','address_en')->where('del',1)->where('id', '!=', 1)->get();
        return view('livewire.frontend.contact-component', compact('branchs'))
        ->layout('layouts.frontend.base-frontend');
    }

    protected $rules = [
        'name'=>'required',
        'phone'=> 'required',
        //'subject'=>'required',
        'message'=> 'required'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function resetField()
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        //$this->subject = '';
        $this->message = '';
    }

    public $name, $email, $phone, $subject, $message;
    public function sendMessage()
    {
        $this->validate();
        Message::create([
            'name'=>$this->name,
            'email'=>$this->email,
            'phone'=>$this->phone,
            //'subject'=>$this->subject,
            'message'=>$this->message
        ]);
        $this->emit('alert', ['type' => 'success', 'message' => 'Your message sent!']);
        $this->resetField();
    }
}
